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

    public function store(Request $request)
    {
        return 1;
    }

    public function view($slug)
    {
        if($slug!='search'){
            $categories = Category::where('slug',$slug)->first();

            return Inertia::render('Category/view', [
                'categories' => $categories
            ]);
        }else return redirect()->route('Category.index');

    }
}
