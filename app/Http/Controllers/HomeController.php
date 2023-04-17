<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use App\Models\Category;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function eventPage($slug)
    {
        $event = Event::where('slug', $slug)
            ->with('department')
            ->with('categories')
            ->with('speakers')
            ->with('promos')
            ->with('schedules')
            ->first();

        return Inertia::render('Homepage/EventPage', [
            'event' => $event,
            'loggedInUser' => auth()->user()
        ]);
    }


    // Homepage
    public function homepage()
    {
        // Get the categories
        $categories = Category::take(7)
            ->get(['slug', 'name']);

        // Temporariry query (Get the assigned events set as slider)
        $events = Event::orderBy('created_at', 'DESC')
            ->with('partner')
            ->with('categories')
            ->with('speakers')
            ->with('promos')
            ->with('schedules')
            ->paginate(8);

        return Inertia::render('Homepage/index',[
            'categories' => $categories,
            'events' => $events
        ]);
    }

    public function donate(Request $request)
    {
        $stripe = new StripeClient("sk_test_51KPSpAGYOLqshLviUHUjYPWiNdE4Cw2vMsRH9wVy1KtmjTwoxnqUcPc8og4YXSREiivgYci3ZzhD8DcOMXtuHz4q00owR1EMzw");

        $finalAmount = ($request->amount=='custom' ? $request->customAmount : $request->amount)*100;

        $title = 'Online Donation Testing';
        $desc = 'Testing for online donation.This wraps up the quickstart. See the links';
        $desc .= 'below for a few different ways to process a payment for the product you just created.';

        $checkout_session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
            'line_items' => [
                [
                    'price_data' => [
                        'product_data' => [
                            'name' => 'test',
                            'description' => 'testtesteststs',
                        ],
                        'currency' => 'usd',
                        'unit_amount' => 1000,
                    ],
                    'quantity' => 1,
                ]
            ],
        ]);

        return response('', 409)->header('X-Inertia-Location', $checkout_session->url);
    }


    /**
     * Checkout: Process Payment
     */
    public function processPayment(Request $request)
    {

        $lineItems = [];

        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $items = $request->cartItems;
        $customer = $request->customerInfo;

        $checkedout_programcode = [];

        foreach ($items as $key => $item)
        {
            $finalAmount = ($item['price'] - $item['discount'])*100;

            array_push($lineItems, [
                'price_data' => [
                    'product_data' => [
                        'name' => $item['title'],
                        'description' => strlen($item['description']) > 60 ? substr($item['description'],0,60)."..." : $item['description'],
                        'images' => [$item['banner']],
                        'metadata' => [
                            'programCode' => $item['programCode'],
                        ],
                    ],
                    'currency' => 'usd',
                    'unit_amount' => $finalAmount,
                ],
                'quantity' => 1,
            ]);

            array_push($checkedout_programcode, json_encode([
                    'programCode' => $item['programCode'],
                    'price' => $item['price'],
                    'discount' => $item['discount']
                ])
            );
        }

        $finalStripeItem = [
            'mode' => 'payment',
            'customer_email' => 'marnelle.apat@bible.org.sg', // use the email address of the registrant
            'metadata' => $checkedout_programcode,
            'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
            'line_items' => $lineItems,
        ];


        /**
         * FLOW
         * 1. Save the customer information. For guest checkout, create new customer record. For logged in user,
         *    just copy the essential info from the USER record. Unique identifier is email address.
         * 2. Store the checked out item to the ORDER and ORDER_ITEMS table, including all the item information and customer id
         * 3. Proceed to the Success Page after the payment and summarize the transaction.
         * 4. If the user won't proceed the payment, delete the order and order_item record.
         */

        $checkout_session = $stripe->checkout->sessions->create($finalStripeItem);

        return response('', 409)->header('X-Inertia-Location', $checkout_session->url);

    }

    /***
     * NOT FOUND PAGE
     *
     */
    public function NotFound()
    {
        return Inertia::render('Homepage/NotFound');
    }

}
