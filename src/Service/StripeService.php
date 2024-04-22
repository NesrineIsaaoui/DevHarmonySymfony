<?php
namespace App\Service;

use Stripe\StripeClient;

class StripeService
{
    private $stripe;

    public function __construct(string $secretKey)
    {
        $this->stripe = new StripeClient($secretKey);
    }

    public function createCheckoutSession(float $amount, string $currency, string $description): object
    {
        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'unit_amount' => $amount * 100, // Stripe expects amount in cents
                    'product_data' => [
                        'name' => $description,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'YOUR_SUCCESS_URL', // Update with your success URL
            'cancel_url' => 'YOUR_CANCEL_URL', // Update with your cancel URL
        ]);
    }
}
