<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function index()
    {
        $partners = Department::with('users')->paginate();

        return Inertia::render('Partners/index', [
            'partners' => $partners
        ]);
    }

    public function create()
    {
        return Inertia::render('Partners/create');
    }
}
