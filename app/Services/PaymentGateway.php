<?php

namespace App\Services;

use Stripe\StripeClient;

class PaymentGateway
{
    private $paymentType;

    public function __construct($type)
    {
        $this->paymentType = $type;
    }

    public function processPayment($request, $order)
    {
        // stripe payment
        if($this->paymentType=='credit card')
        {
            $stripe = new StripeClient(env('STRIPE_SECRET'));
            $finalAmount = ((!empty($request->promoApplied) && $request->promoApplied['status']) ? $request->promoApplied['promo']['discountPrice'] : $request->event['price'])*100;
            $title = $request->event['title'];
            $desc = $request->event['description'];
            $img = $request->event['banner'];

            //create customer account to stripe and checkout session
            $checkout_session = $stripe->checkout->sessions->create([
                'mode' => 'payment',
                'success_url' => route('success').'?order_number='.$order->orderNumber.'&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
                // 'customer' => [
                //     'name' => $request->customer['firstName'] . ' ' . $request->customer['lastName'],
                //     'description' => 'Customer stripe account creation for '. $request->event['programCode'],
                //     'email' => $request->customer['email'],
                //     'phone' => $request->customer['phoneNumber'],
                //     'meta_data' => [
                //         'programCode' => $request->event['programCode'],
                //         'registrationNumber' => $order->orderNumber
                //     ]
                // ],
                'line_items' => [
                    [
                        'price_data' => [
                            'product_data' => [
                                'name' => $title,
                                'description' => $desc,
                                'images' => [$img]
                            ],
                            'currency' => env('PAYMENT_CURRENCY'),
                            'unit_amount' => $finalAmount
                        ],
                        'quantity' => 1,
                    ]
                ],
            ]);

            return $checkout_session;
        }
        // else if($this->paymentType=='cheque')
        // {
        //     dd('This is cheque payment');
        // }
    }


}

