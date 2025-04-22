<?php
session_start();
include "database.php";
require 'vendor/autoload.php';

$user_id = $_SESSION['user_id'];

\Stripe\Stripe::setApiKey('sk_test_51QomvwR3rIyanQnHomFEx3J6p3lztGZBJ7VmcwuEh8rM7ayIo4VSfCL0ZHHd38py9lypcq5BiLid2nMnn2tsjsLh00ST1xNI1v');
$input = json_decode(file_get_contents('php://input'), true);
$items = $input['items'];

$line_items = [];

foreach ($items as $item) {
    $id = intval($item['id']);
    $quantity = intval($item['quantity']);

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT product_name, product_price FROM product WHERE product_ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $line_items[] = [
            'price_data' => [
                'currency' => 'thb',
                'product_data' => [
                    'name' => $row['product_name'],
                ],
                'unit_amount' => intval($row['product_price'] * 100),
            ],
            'quantity' => $quantity,
        ];
    }

    $stmt->close();
}

if (!empty($line_items)) {
    try {
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => 'https://91e3-134-236-161-121.ngrok-free.app/MiniProject5/payment-success.php',  // Update this URL for production or ngrok
            'cancel_url' => 'https://91e3-134-236-161-121.ngrok-free.app/MiniProject5/payment-failed.php',  // Same here
            'metadata' => [
                'user_id' => $user_id,
                ],
            'billing_address_collection' => 'required',
            'shipping_address_collection' => [
                'allowed_countries' => ['TH'],
            ],
            'phone_number_collection' => [
                'enabled' => true,
            ],
        ]);

        echo json_encode(['id' => $session->id]);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No items in cart']);
}
