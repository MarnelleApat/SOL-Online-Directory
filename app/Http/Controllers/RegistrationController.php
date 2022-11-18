<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RegistrationController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/registration');
    }

    public function register($event_id, Request $request)
    {
        // if the registrants is logged in user
        if(auth()->user())
        {
            dd($event_id, auth()->user());
        }

        // if the registrants is not logged-in (GUEST)
        else
        {
            $request->validate([
                'nirc'                  => 'required',
                'username'              => 'required|unique:users',
                'password'              => 'required|min:8|confirmed',
                'password_confirmation' => 'required|min:8',
                'email'                 => 'required|string|email|max:255|unique:users',
                'firstName'             => 'required|string|max:255',
                'lastName'              => 'required|string|max:255',
                'phoneNumber'           => 'required',
                'address'               => 'required',
                'city'                  => 'required',
                'postalCode'            => 'required',
                'country'               => 'required',
                'church'                => 'string',
                'gender'                => 'required',
                'billingAddress'        => 'required',
                'shippingAddress'       => 'required',
            ]);

            dd($event_id,$request->all());
        }

        // return redirect()->back();
        // check if AUTH is not NULL
        // If TRUE
            // Store registration record
        return Inertia::render('Users/registration');
    }
}
