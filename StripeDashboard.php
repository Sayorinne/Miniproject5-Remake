<?php
require_once('vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_51QomvwR3rIyanQnHomFEx3J6p3lztGZBJ7VmcwuEh8rM7ayIo4VSfCL0ZHHd38py9lypcq5BiLid2nMnn2tsjsLh00ST1xNI1v'); // Replace with your actual secret key

function getStripeData() {
    try {
        $balance = \Stripe\Balance::retrieve();
        $payments = \Stripe\PaymentIntent::all([
            'limit' => 10,
            'expand' => ['data.customer', 'data.payment_method']
        ]);
        $customers = \Stripe\Customer::all(['limit' => 5]);
        $subscriptions = \Stripe\Subscription::all(['limit' => 5, 'expand' => ['data.customer']]);
        $products = \Stripe\Product::all(['limit' => 5]);
        
        return [
            'balance' => $balance,
            'payments' => $payments->data,
            'customers' => $customers->data,
            'subscriptions' => $subscriptions->data,
            'products' => $products->data
        ];
    } catch (\Stripe\Exception\ApiErrorException $e) {
        return ['error' => $e->getMessage()];
    }
}

$data = getStripeData();
header('Content-Type: application/json');
echo json_encode($data);