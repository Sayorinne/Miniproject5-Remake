<?php
session_start();
include "database.php";
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51QomvwR3rIyanQnHomFEx3J6p3lztGZBJ7VmcwuEh8rM7ayIo4VSfCL0ZHHd38py9lypcq5BiLid2nMnn2tsjsLh00ST1xNI1v');

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    $sql = "SELECT product_name, product_price FROM product WHERE product_ID = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'thb',
                    'product_data' => [
                        'name' => $row['product_name'],
                    ],
                    'unit_amount' => $row['product_price'] * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://localhost/Miniproject5/payment-success.php',
            'cancel_url' => 'http://localhost/Miniproject5/payment-failed.php',
            'billing_address_collection' => 'required',
            'shipping_address_collection' => [
                'allowed_countries' => ['TH'], // Add other countries as needed
            ],
            'phone_number_collection' => [
                'enabled' => true,
            ],
        ]);

        echo json_encode(['id' => $session->id]);
    } else {
        echo json_encode(['error' => 'Product not found']);
    }
} else {
    echo json_encode(['error' => 'No product ID provided']);
}