<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Redirect;
use App\Http\Requests\{ StoreDepartmentRequest,UpdateDepartmentRequest };

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

    public function store(StoreDepartmentRequest $request)
    {
        $partners = Department::create([
            'name' => $request->name,
            'slug' => $this->createSlug($request->name),
            'description' => $request->description,
            'websiteUrl' => $request->websiteUrl,
            'status' => 1,
        ]);

        if($partners)
            return Redirect::route('partners.index');
    }

    public function update(UpdateDepartmentRequest $request)
    {
        $partners = Department::where('slug',$request->slug)->update([
            'name' => $request->name,
            'description' => $request->description,
            'websiteUrl' => $request->websiteUrl,
            'status' => $request->status,
        ]);

        return Redirect::route('partners.view', ['slug' => $request->slug]);
    }

    public function view($slug)
    {
        $partners = Department::where('slug',$slug)->first();
        
        return Inertia::render('Partners/view', [
            'partners' => $partners,
            'status' => $partners->status
        ]); 
    }

    public function search(Request $request)
    {
        $partners = Department::where('name','LIKE',$request->keyword)->get();

        return Inertia::render('Partners/index', [
            'partners' => $partners
        ]);
    }

    private function createSlug($title, $id = 0)
    {
        $slug = Str::slug($title);
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        $i = 1;
        $is_contain = true;
        do {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                $is_contain = false;
                return $newSlug;
            }
            $i++;
        } while ($is_contain);
    }

    private function getRelatedSlugs($slug, $id = 0)
    {
        return Department::select('slug')->where('slug', 'like', $slug.'%')
        ->where('id', '<>', $id)
        ->get();
    }
}
