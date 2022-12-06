<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

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

        $user = User::create([
            'nirc'                  => $request->nirc,
            'niceName'              => $request->firstName.' '.$request->lastName,
            'username'              => $request->username,
            'password'              => Hash::make($request->password),
            'email'                 => $request->email,
            'firstName'             => $request->firstName,
            'lastName'              => $request->lastName,
            'phoneNumber'           => $request->phoneNumber,
            'address'               => $request->address,
            'city'                  => $request->city,
            'postalCode'            => $request->postalCode,
            'country'               => $request->country,
            'church'                => $request->church,
            'gender'                => $request->gender,
            'billingAddress'        => json_encode($request->billingAddress, true),
            'shippingAddress'       => json_encode($request->shippingAddress, true),
        ]);


        event(new Registered($user));

        Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        return redirect()->back();
    }
}
