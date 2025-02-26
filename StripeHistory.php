<?php
require_once('vendor/autoload.php');

\Stripe\Stripe::setApiKey('sk_test_51QomvwR3rIyanQnHomFEx3J6p3lztGZBJ7VmcwuEh8rM7ayIo4VSfCL0ZHHd38py9lypcq5BiLid2nMnn2tsjsLh00ST1xNI1v');

class StripeHistory {
    public static function getTransactionHistory($limit = 50) {
        try {
            $charges = \Stripe\Charge::all(['limit' => $limit, 'expand' => ['data.payment_intent', 'data.customer']]);
            $transactions = [];
            foreach ($charges->data as $charge) {
                $paymentIntent = $charge->payment_intent;
                $customer = $charge->customer;

                $transactions[] = [
                    'id' => $charge->id,
                    'amount' => $charge->amount / 100,
                    'currency' => strtoupper($charge->currency),
                    'status' => $charge->status,
                    'date' => date('Y-m-d H:i:s', $charge->created),
                    'customer_name' => $charge->billing_details->name ?? 'Not Provided',
                    'customer_email' => $charge->billing_details->email ?? 'Not Provided',
                    'customer_phone' => $charge->billing_details->phone ?: 'Not Provided',
                    'billing_address' => self::formatAddress($charge->billing_details->address),
                    'payment_method' => $charge->payment_method_details->type ?? 'Not Provided',
                    'debug_info' => [
                        'charge_id' => $charge->id,
                        'charge_metadata' => $charge->metadata->toArray(),
                        'charge_billing_details' => $charge->billing_details->toArray(),
                        'payment_intent' => $paymentIntent ? [
                            'id' => $paymentIntent->id,
                            'metadata' => $paymentIntent->metadata->toArray(),
                        ] : null,
                        'customer' => $customer ? [
                            'id' => $customer->id,
                            'name' => $customer->name,
                            'email' => $customer->email,
                            'phone' => $customer->phone,
                        ] : null,
                        'payment_method_details' => $charge->payment_method_details,
                    ],
                ];
            }
            return $transactions;
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    private static function formatAddress($address) {
        if (!$address) return 'Not Provided';
        
        $parts = [
            $address->line1 ?? '',
            $address->line2 ?? '',
            $address->city ?? '',
            $address->state ?? '',
            $address->postal_code ?? '',
            $address->country ?? ''
        ];

        $formattedAddress = implode(', ', array_filter($parts));
        return $formattedAddress ?: 'Not Provided';
    }
}
