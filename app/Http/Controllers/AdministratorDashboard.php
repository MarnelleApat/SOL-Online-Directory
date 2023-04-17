<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class AdministratorDashboard extends Controller
{
    public function home()
    {
        $user = auth()->user();

        return Inertia::render('Admin/Dashboard', [
            'user' => $user
        ]);
    }
}
