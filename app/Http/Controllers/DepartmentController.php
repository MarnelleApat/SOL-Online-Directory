<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Inertia\Inertia;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index()
    {
        $partners = Department::with('users')->orderBy('id','desc')->paginate();

        return Inertia::render('Partners/index', [
            'partners' => $partners
        ]);
    }

    public function create()
    {
        return Inertia::render('Partners/create');
    }

    public function store(Request $request)
    {

        $partners = Department::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'websiteUrl' => $request->websiteUrl,
            'status' => 1,
        ]);

        $partners = Department::with('users')->paginate();

        return Inertia::render('Partners/index', [
            'partners' => $partners
        ]);
    }

    public function delete(Request $request)
    {
        Department::find($request->id)->delete();
        
        $partners = Department::with('users')->paginate();

        return Inertia::render('Partners/index', [
            'partners' => $partners
        ]);
    }

    public function view(Request $request)
    {
        $partners = Department::find($request->id);
        
        return Inertia::render('Partners/view', [
            'partners' => $partners
        ]); 
    }
}
