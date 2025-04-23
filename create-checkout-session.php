<?php
session_start();
include "database.php";
require 'vendor/autoload.php';

$user_id = $_SESSION['user_id'];

// Retrieve the pending cart ID for the current user
$stmt = $conn->prepare("SELECT Cart_ID FROM shopping_cart WHERE User_ID = ? AND Status = 'pending' LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_id = $result->fetch_assoc()['Cart_ID'];

// Initialize Stripe API
\Stripe\Stripe::setApiKey('sk_test_51QomvwR3rIyanQnHomFEx3J6p3lztGZBJ7VmcwuEh8rM7ayIo4VSfCL0ZHHd38py9lypcq5BiLid2nMnn2tsjsLh00ST1xNI1v');

// Fetch all items from the cart
$stmt = $conn->prepare("SELECT * FROM cart_item WHERE Cart_ID = ?");
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$result = $stmt->get_result();

$line_items = [];

// Loop through each item in the cart
while ($row = $result->fetch_assoc()) {
    $id = $row['Product_ID'] ?? $row['Art_ID']; // Use Product_ID or Art_ID based on the type
    $quantity = intval($row['Quantity']);
    $product_type = $row['type']; // 'artproduct' or 'product'

    // Fetch product details based on the product type
    if ($product_type == 'artproduct') {
        $stmt2 = $conn->prepare("SELECT Art_name AS product_name, Art_price AS product_price FROM artproduct WHERE Art_ID = ?");
    } 
    if ($product_type == 'product') {
        $stmt2 = $conn->prepare("SELECT product_name, product_price FROM product WHERE product_ID = ?");
    }

    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $product_result = $stmt2->get_result();

    if ($product_result->num_rows > 0) {
        $product = $product_result->fetch_assoc();
        // Prepare the item for Stripe Checkout
        $line_items[] = [
            'price_data' => [
                'currency' => 'thb',
                'product_data' => [
                    'name' => $product['product_name'],
                ],
                'unit_amount' => intval($product['product_price'] * 100), // Stripe requires price in cents
            ],
            'quantity' => $quantity,
        ];
    }

    $stmt2->close();
}

$stmt->close();

// If there are items in the cart, create a Stripe Checkout session
if (!empty($line_items)) {
    try {
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => 'https://071a-110-77-198-93.ngrok-free.app/MiniProject5/payment-success.php',  // Update this URL for production or ngrok
            'cancel_url' => 'https://071a-110-77-198-93.ngrok-free.app/MiniProject5/payment-failed.php',  // Same here
            'payment_intent_data' => [
                'metadata' => [
                    'user_id' => $user_id,
                    'from_cart' => 'yes',
                    'cart_id' => $cart_id,
                ],
            ],
            'metadata' => [
                'user_id' => $user_id,
                'from_cart' => 'yes',
                'cart_id' => $cart_id,
            ],
            'billing_address_collection' => 'required',
            'shipping_address_collection' => [
                'allowed_countries' => ['TH'],
            ],
            'phone_number_collection' => [
                'enabled' => true,
            ],
        ]);

        // Return the session ID to the client to start the checkout process
        echo json_encode(['id' => $session->id]);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No items in cart']);
}
?>