<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return Inertia::render('Category/index', [
            'categories' => $categories
        ]);
    }

    public function getAll()
    {
        $categories = Category::all();

        return response()->json('categories');
    }
}
