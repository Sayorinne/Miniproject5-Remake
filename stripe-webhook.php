<?php
require 'vendor/autoload.php';
include "database.php";
ini_set('log_errors', 1);
ini_set('error_log', 'c:/AppServ/www/MiniProject5/webhook_error.log');
error_reporting(E_ALL);

// Stripe secret
$endpoint_secret = 'whsec_LX2aCSJQz67q5x9Cp6lwyc6w8KXS3nrE';

$payload = @file_get_contents("php://input");
$sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];
$event = null;

try {
    // For testing: skip signature verification
    $event = json_decode($payload);
} catch (\Exception $e) {
    http_response_code(400);
    echo error_log("Webhook error: " . $e->getMessage());
    exit();
}

error_log("Received event type: " . $event->type);

if ($event->type === 'checkout.session.completed') {
    $session = $event->data->object;

    error_log("Session object: " . json_encode($session));

    // Extract metadata
    $metadata = $session->metadata ?? null;
    $user_id = $metadata->user_id ?? null;
    $from_cart = $metadata->from_cart ?? 'no';
    $product_id = $metadata->product_id ?? null;
    $product_type = $metadata->product_type ?? null;
    $quantity = (int) ($metadata->quantity ?? 1);

    // Validate metadata
    if (!$metadata || !$user_id) {
        error_log("Missing metadata or user_id.");
        http_response_code(400);
        exit();
    }
    // Log extracted quantity for debugging
    error_log("Extracted quantity: $quantity");
    error_log("Extracted type: $product_type");

    // Extract shipping details
    $shipping = $session->shipping_details ?? null;
    $customer_details = $session->customer_details ?? null;

    $shipping_name = $shipping->name ?? $customer_details->name ?? 'Unknown';
    $shipping_phone = $shipping->phone ?? $customer_details->phone ?? 'Unknown';

    $address_parts = [
        $shipping->address->line1 ?? $customer_details->address->line1 ?? '',
        $shipping->address->line2 ?? $customer_details->address->line2 ?? '',
        $shipping->address->city ?? $customer_details->address->city ?? '',
        $shipping->address->state ?? $customer_details->address->state ?? '',
        $shipping->address->postal_code ?? $customer_details->address->postal_code ?? '',
        $shipping->address->country ?? $customer_details->address->country ?? '',
    ];
    $shipping_address = implode(', ', array_filter($address_parts));

    // Calculate total amount from session
    $totalAmount = $session->amount_total / 100; // Stripe returns in cents

    // Check if the payment_intent already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM purchases WHERE PaymentIntent_ID = ?");
    if (!$stmt) {
        error_log("SQL Error (check payment_intent): " . $conn->error);
        http_response_code(500);
        exit();
    }
    $stmt->bind_param("s", $session->payment_intent);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        error_log("Duplicate payment_intent detected: " . $session->payment_intent);
        http_response_code(200); // Acknowledge the webhook to prevent retries
        exit();
    }

    // Insert into purchases
    $stmt = $conn->prepare("INSERT INTO purchases 
        (User_ID, Purchase_Date, Total_Amount, PaymentIntent_ID, Shipping_Name, Shipping_Phone, Shipping_Address, Status)
        VALUES (?, NOW(), ?, ?, ?, ?, ?, 'paid')");
    if (!$stmt) {
        error_log("SQL Error (purchases): " . $conn->error);
        http_response_code(500);
        exit();
    }
    $stmt->bind_param("sdssss", $user_id, $totalAmount, $session->payment_intent, $shipping_name, $shipping_phone, $shipping_address);
    $stmt->execute();
    $purchase_id = $stmt->insert_id;

    // Handle purchase_items
    if ($from_cart === 'yes') {
        // Handle cart purchase
        $cart_id = $metadata->cart_id ?? null;
        if (!$cart_id) {
            error_log("Missing cart_id.");
            http_response_code(400);
            exit();
        }

        $stmt = $conn->prepare("SELECT * FROM cart_item WHERE Cart_ID = ?");

        if (!$stmt) {
            error_log("SQL Error (cart_item): " . $conn->error);
            http_response_code(500);
            exit();
        }
        
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['Product_ID'];
            $art_id = $row['Art_ID'];
            $quantity = $row['Quantity'];
            $type = $row['type']; // 'product' or 'artproduct'
        
            if ($type === 'product') {
                // Insert product into purchase_items
                $stmt3 = $conn->prepare("INSERT INTO purchase_items (Purchase_ID, product_ID, Quantity) VALUES (?, ?, ?)");
                if (!$stmt3) {
                    error_log("SQL Error (purchase_items - product): " . $conn->error);
                    http_response_code(500);
                    exit();
                }
                $stmt3->bind_param("iii", $purchase_id, $product_id, $quantity);
            } elseif ($type === 'artproduct') {
                // Insert artproduct into purchase_items
                $stmt3 = $conn->prepare("INSERT INTO purchase_items (Purchase_ID, Art_ID, Quantity) VALUES (?, ?, ?)");
                if (!$stmt3) {
                    error_log("SQL Error (purchase_items - artproduct): " . $conn->error);
                    http_response_code(500);
                    exit();
                }
                $stmt3->bind_param("iii", $purchase_id, $art_id, $quantity);
            } else {
                error_log("Unknown item type in cart_item: " . $type);
                continue;
            }
        
            // Execute the query
            if (!$stmt3->execute()) {
                error_log("Execution Error (purchase_items): " . $stmt3->error);
                http_response_code(500);
                exit();
            }
        }

        $stmt = $conn->prepare("UPDATE shopping_cart SET Status = 'completed' WHERE Cart_ID = ?");
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
    } else {

        // Handle single product purchase
        if ($product_type === 'product') {
            if (!$product_id || $quantity <= 0) {
                error_log("Invalid product_id or quantity for product.");
                http_response_code(400);
                exit();
            }
            $stmt = $conn->prepare("INSERT INTO purchase_items (Purchase_ID, product_ID, Quantity) VALUES (?, ?, ?)");
            if (!$stmt) {
                error_log("SQL Error (product): " . $conn->error);
                http_response_code(500);
                exit();
            }
            $stmt->bind_param("iii", $purchase_id, $product_id, $quantity);
        } else {
            if (!$product_id || $quantity <= 0) {
                error_log("Invalid product_id or quantity for artproduct.");
                http_response_code(400);
                exit();
            }
            $stmt = $conn->prepare("INSERT INTO purchase_items (Purchase_ID, Art_ID, Quantity) VALUES (?, ?, ?)");
            if (!$stmt) {
                error_log("SQL Error (artproduct): " . $conn->error);
                http_response_code(500);
                exit();
            }
            $stmt->bind_param("iii", $purchase_id, $product_id, $quantity);
        }

        // Execute the query
        if (!$stmt->execute()) {
            error_log("Execution Error (purchase_items): " . $stmt->error);
            http_response_code(500);
            exit();
        }



    }
    // Notification
    $title = "การทำธุรกรรมสำเร็จ";
    $content = "มีการทำธุรกรรมสำเร็จสำหรับการสั่งซื้อของคุณ โปรดตรวจสอบรายละเอียดการสั่งซื้อ";
    $type = "shopping";

    $stmt = $conn->prepare("INSERT INTO notifications (User_ID, title, content, type) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        error_log("SQL Error (notifications): " . $conn->error);
        http_response_code(500);
        exit();
    }
    $stmt->bind_param("ssss", $user_id, $title, $content, $type);
    $stmt->execute();
}

http_response_code(200);
echo "Webhook handled.";
?>