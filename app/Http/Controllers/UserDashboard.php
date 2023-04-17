<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class UserDashboard extends Controller
{
    public function home()
    {
        return Inertia::render('Users/Dashboard');
    }
}
