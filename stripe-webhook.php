<?php
require 'vendor/autoload.php';
include "database.php";

$endpoint_secret = 'whsec_...';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
$event = null;

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch(\UnexpectedValueException $e) {
    http_response_code(400);
    exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    http_response_code(400);
    exit();
}

if ($event->type == 'checkout.session.completed') {
    $session = $event->data->object;
    
    // Update the transaction in your database
    $sql = "UPDATE transactions SET 
            status = ?, 
            stripe_payment_intent_id = ?,
            shipping_name = ?,
            shipping_address_line1 = ?,
            shipping_address_line2 = ?,
            shipping_city = ?,
            shipping_state = ?,
            shipping_postal_code = ?,
            shipping_country = ?,
            phone_number = ?
            WHERE stripe_session_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssss", 
        'completed',
        $session->payment_intent,
        $session->shipping->name,
        $session->shipping->address->line1,
        $session->shipping->address->line2,
        $session->shipping->address->city,
        $session->shipping->address->state,
        $session->shipping->address->postal_code,
        $session->shipping->address->country,
        $session->customer_details->phone,
        $session->id
    );
    $stmt->execute();
}

http_response_code(200);