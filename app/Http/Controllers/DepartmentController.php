<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Redirect;
use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    public function index()
    {
        $partners = Department::with('users')->orderBy('id','desc')->paginate(7);

        return Inertia::render('Partners/index', [
            'partners' => $partners,
            'isOpen' => false
        ]);
    }

    public function create()
    {
        return Inertia::render('Partners/create');
    }

    public function store(DepartmentRequest $request)
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
