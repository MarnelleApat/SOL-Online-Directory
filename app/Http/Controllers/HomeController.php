<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use Stripe\StripeClient;
use App\WPRestApi\WP_Post;
use Illuminate\Http\Request;
use App\WPRestApi\WP_Category;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function eventPage($slug)
    {
        $event = Event::where('slug', $slug)
            ->with('department')
            ->with('categories')
            ->with('speakers')
            ->with('schedules')
            ->first();

        return Inertia::render('Homepage/EventPage', [
            'event' => $event,
            'loggedInUser' => auth()->user()
        ]);
    }

    // testing stripe processes

    public function homepage()
    {
        $prices = DB::table('prices')->get();

        return Inertia::render('Homepage/Main', [
           'prices' => $prices
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
                            'name' => $title,
                            'description' => $desc,
                        ],
                        'currency' => 'usd',
                        'unit_amount' => $finalAmount,
                    ],
                    'quantity' => 1,
                ]
            ],
        ]);

        return response('', 409)->header('X-Inertia-Location', $checkout_session->url);
    }


    public function success()
    {
        $stripe = new StripeClient("sk_test_51KPSpAGYOLqshLviUHUjYPWiNdE4Cw2vMsRH9wVy1KtmjTwoxnqUcPc8og4YXSREiivgYci3ZzhD8DcOMXtuHz4q00owR1EMzw");
        $session = $stripe->checkout->sessions->retrieve($_GET['session_id']);
        $customer = $stripe->customers->retrieve($session->customer);

        return Inertia::render('Homepage/Success', [
            'session' => $session,
            'customer' => $customer
        ]);
    }

    public function cancel()
    {
        return Inertia::render('Homepage/Cancel');
    }

    // end of testing stripe processes


    public function PostByCategory( WP_Category $wp_category, WP_Post $wp_post, $category_slug )
    {
        $categories = $wp_category->get();
        $category = $wp_category->get_cat_by_slug($category_slug);
        $articles = $wp_post->get_post_by_category_id( $category['id'] );

        return Inertia::render( 'Articles/ArticlesByCategory', [
            'articles' => $articles,
            'category_name' => $category['name'],
            'navigationMenu' => $categories
        ]);
    }

    public function SingleArticle( WP_Category $wp_category, WP_Post $wp_post, $article_slug )
    {
        $categories = $wp_category->get();
        $post = $wp_post->get_single_post( $article_slug );

        return Inertia::render( 'Articles/Single', [
            'article' => $post,
            'navigationMenu' => $categories
        ]);
    }


}
