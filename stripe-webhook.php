<?php
session_start();
require 'vendor/autoload.php';
include "database.php";

$endpoint_secret = 'whsec_LX2aCSJQz67q5x9Cp6lwyc6w8KXS3nrE';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );  
    error_log("Event constructed successfully: " . $event->type);
} catch(\UnexpectedValueException $e) {
    error_log("Invalid payload: " . $e->getMessage());
    http_response_code(400);
    exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    error_log("Invalid signature: " . $e->getMessage());
    http_response_code(400);
    exit();
}

// Debug database connection
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    http_response_code(500);
    exit();
} else {
    error_log("Database connection successful");
}


error_log("Webhook received. Event type: " . $event->type);

if ($event->type == 'payment_intent.succeeded') {
    $paymentIntent = $event->data->object;
    error_log("PaymentIntent ID: " . $paymentIntent->id);

    $metadata = $paymentIntent->metadata;
    error_log("Metadata received: " . json_encode($metadata));

    $user_id = $metadata->user_id ?? 'unknown';
    error_log("Extracted User ID: $user_id");

    // Insert notification into database
    $title = "การทำธุรกรรมสำเร็จ";
    $content = "มีการทำธุรกรรมสำเร็จสำหรับการสั่งซื้อของคุณ โปรดตรวจสอบรายละเอียดการสั่งซื้อ";
    $type = "shopping";

    $sql = "INSERT INTO notifications (User_ID, title, content, type) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('ssss', $user_id, $title, $content, $type);
        if ($stmt->execute()) {
            error_log("Notification inserted successfully for user: $user_id");
        } else {
            error_log("Failed to insert notification: " . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log("Failed to prepare statement: " . $conn->error);
    }
} else {
    error_log("Received event type: " . $event->type);
}

error_log("Webhook processing completed");
http_response_code(200);