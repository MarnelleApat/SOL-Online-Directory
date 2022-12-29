<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Customer;
use App\Models\Event;
use App\Models\Order;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/registration');
    }

    public function registerCustomer($event_id, Request $request)
    {
        # 0. Validation
        $request->validate([
            'nirc'             => 'numeric',
            'email'            => 'required|email',
            'firstName'        => 'required',
            'lastName'         => 'required',
            'phoneNumber'      => 'required',
            'address'          => 'string',
            'city'             => 'string',
            'postalCode'       => 'string',
            'country'          => 'string',
            'church'           => 'string',
            'gender'           => 'required'
        ]);

        # 1. Query the customer, If email is exist, get the customer data
        $customer = Customer::firstOrCreate(['email' => $request->email]);

        # 2. Else, Add new customer record
        $customer->nirc             = $request['nirc'];
        $customer->email            = $request['email'];
        $customer->firstName        = $request['firstName'];
        $customer->lastName         = $request['lastName'];
        $customer->phoneNumber      = $request['phoneNumber'];
        $customer->address          = $request['address'];
        $customer->city             = $request['city'];
        $customer->postalCode       = $request['postalCode'];
        $customer->country          = $request['country'];
        $customer->church           = $request['church'];
        $customer->billingAddress   = $request['billingAddress'];
        $customer->shippingAddress  = $request['shippingAddress'];
        $customer->gender           = $request['gender'];
        $customer->meta_data        = $request['meta_data'];
        $customer->save();

        return response()->json($customer, 200);

    }
}
