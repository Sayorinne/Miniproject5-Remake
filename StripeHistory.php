<?php
require_once('vendor/autoload.php');

class StripeHistory {
    public static function getTransactionHistory($limit = 50) {
        try {
            $stripe = new \Stripe\StripeClient('sk_test_51QomvwR3rIyanQnHomFEx3J6p3lztGZBJ7VmcwuEh8rM7ayIo4VSfCL0ZHHd38py9lypcq5BiLid2nMnn2tsjsLh00ST1xNI1v');
            $charges = $stripe->charges->all(['limit' => $limit]);
            $transactions = [];

            foreach ($charges->data as $charge) {
                $transactions[] = [
                    'id' => $charge->id,
                    'amount' => $charge->amount / 100,
                    'currency' => strtoupper($charge->currency),
                    'status' => $charge->status,
                    'date' => date('Y-m-d H:i:s', $charge->created),
                    'customer_name' => $charge->billing_details->name ?? 'Not Provided',
                    'customer_email' => $charge->billing_details->email ?? 'Not Provided',
                    'customer_phone' => $charge->billing_details->phone ?? 'Not Provided',
                    'billing_address' => self::formatAddress($charge->billing_details->address),
                    'payment_method' => $charge->payment_method_details->type ?? 'Not Provided',
                    'receipt_url' => $charge->receipt_url ?? null,
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