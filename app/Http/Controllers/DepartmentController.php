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
    public function __construct(Slug $slug,Department $department)
    {
        $this->slug = $slug;
        $this->deparment_model = $department;
    }

    public function index()
    {
        $partners = $this->deparment_model->with('users')
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

    public function store(StoreDepartmentRequest $request)
    {
        $user = Auth::user();

        $partners = $this->deparment_model->create([
            'name' => $request->name,
            'slug' => $this->slug->createSlug($request->name,$this->deparment_model),
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
        $partners = $this->deparment_model->where('slug',$request->slug)->update([
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
            $partners = $this->deparment_model->where('slug',$slug)->first();

            return Inertia::render('Partners/view', [
                'partners' => $partners,
                'status' => $partners->status
            ]);
        }else return redirect()->route('partners.index');

    }

    public function search(Request $request)
    {
        if($request->keyword!='null'){
            $model = $this->deparment_model->with('users');
            $model->where('name', 'like', '%' . $request->keyword . '%');
            $partners = $model->where('status',1)->orderBy('id','desc')->paginate(7);
            return Inertia::render('Partners/index', [
                'partners' => $partners,
                'isOpen' => false
            ]);
        }else return redirect()->route('partners.index');
    }
}
