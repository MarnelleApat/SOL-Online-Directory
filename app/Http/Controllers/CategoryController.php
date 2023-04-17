<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\Slug;
use App\Http\Requests\{ StoreCategoryRequest, UpdateCategoryRequest };

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id','DESC')->paginate(7);

        return Inertia::render('Category/index', [
            'categories' => $categories
        ]);
}

    public function store(StoreCategoryRequest $request,Slug $slug,Category $categories)
    {
        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug->createSlug($request->name, $categories),
            'description' => $request->description
        ]);

        if($category)
            return redirect()->route('category.index');
    }

    public function view($slug)
    {
        if($slug!='search'){
            $categories = Category::where('slug',$slug)->first();

            return Inertia::render('Category/view', [
                'categories' => $categories
            ]);
        }else return redirect()->route('category.index');

    }

    public function update(UpdateCategoryRequest $request)
    {
        $categories = Category::where('slug',$request->slug)->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('category.view', ['slug' => $request->slug]);
    }

    public function search(Request $request)
    {
        if($request->keyword!='null'){
            $categories = Category::where('name', 'like', '%' . $request->keyword . '%')->orderBy('id','desc')->paginate(7);
            return Inertia::render('Category/index', [
                'categories' => $categories
            ]);
        }else return redirect()->route('category.index');
    }

    // API call use for fetching all the record for Modal Media Usecase
    public function all()
    {
        $data = Category::all();
        return response()->json($data, 200);

    }
}
