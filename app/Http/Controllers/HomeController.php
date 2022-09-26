<?php

namespace App\Http\Controllers;

use App\WPRestApi\WP_Category;
use App\WPRestApi\WP_Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    public function homepage(WP_Post $wp_post, WP_Category $wp_category)
    {
        $categories = $wp_category->get();
        // $posts = $wp_post->get();

        return Inertia::render('Homepage/Main', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'navigationMenu' => $categories
        ]);
    }
}
