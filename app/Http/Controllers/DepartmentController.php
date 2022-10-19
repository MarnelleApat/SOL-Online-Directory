<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Http\Requests\{ StoreDepartmentRequest, UpdateDepartmentRequest };
use Auth;
use App\Services\Slug;

class DepartmentController extends Controller
{
    public function index()
    {
        $partners = Department::with('users')
        ->where('status',1)
        ->orderBy('id','desc')->paginate(7);

        return Inertia::render('Partners/index', [
            'partners' => $partners,
            'isOpen' => false
        ]);
    }

    public function create()
    {
        return Inertia::render('Partners/create');
    }

    public function store(StoreDepartmentRequest $request,Slug $slug,Department $department)
    {
        $user = Auth::user();

        $partners = Department::create([
            'name' => $request->name,
            'slug' => $slug->createSlug($request->name,$department),
            'description' => $request->description,
            'websiteUrl' => $request->websiteUrl,
            'status' => 1,
        ]);

        $user->departments()->attach($partners->id);

        if($partners)
            return redirect()->route('partners.index');
    }

    public function update(UpdateDepartmentRequest $request)
    {
        $partners = Department::where('slug',$request->slug)->update([
            'name' => $request->name,
            'description' => $request->description,
            'websiteUrl' => $request->websiteUrl,
            'status' => $request->status,
        ]);

        return redirect()->route('partners.view', ['slug' => $request->slug]);
    }

    public function view($slug)
    {
        if($slug!='search'){
            $partners = Department::where('slug',$slug)->first();

            return Inertia::render('Partners/view', [
                'partners' => $partners,
                'status' => $partners->status
            ]);
        }else return redirect()->route('partners.index');

    }

    public function search(Request $request)
    {
        if($request->keyword!='null'){
            $model = Department::with('users');
            $model->where('name', 'like', '%' . $request->keyword . '%');
            $partners = $model->where('status',1)->orderBy('id','desc')->paginate(7);
            return Inertia::render('Partners/index', [
                'partners' => $partners,
                'isOpen' => false
            ]);
        }else return redirect()->route('partners.index');
    }
}
