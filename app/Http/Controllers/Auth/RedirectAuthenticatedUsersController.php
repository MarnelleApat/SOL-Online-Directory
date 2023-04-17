<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectAuthenticatedUsersController extends Controller
{
    public function home()
    {
        if (auth()->user()->role->name == 'Administrator') {
            return redirect('/administrator/dashboard');
        }
        elseif(auth()->user()->role->name == 'AdminUser'){
            return redirect('/admin/dashboard');
        }
        elseif(auth()->user()->role->name == 'User'){
            return redirect('/user/dashboard');
        }
        else{
            return auth()->logout();
        }
    }
}
