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

    public function register($event_id, Request $request)
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



        # 3. query the event details
        $event = Event::find($event_id);

        # 4. Prepare for Customer order creation
        # 5. Generate unique RegistrationCode of the customer to the event by concatinating the EventProgramCode and Event totalRegistrant value
        $order = Order::create([
            'customer_id' => $customer->id,
            'orderNumber' => (new OrderController)->generateOrderNumberForEvent($event_id),
            'productCode' => $event->programCode,
            'price' => $event->price,
            'promo' => null,
            'discount' => 0,
            'TrxID' => '',
            'externalURL' => '',
            'paymentType' => '',
            'paymentReferenceNo' => '',
            'approveBy' => '',
            'customFields' => '',
            'status' => 'PENDING'
        ]);

        # 6. Process Payment

        dd($order);



        // Save the customer / create new customer record

        // Create Order record
        // Process payment


        // return redirect()->back();
        // check if AUTH is not NULL

        // Store registration record
        return Inertia::render('Users/registration');
    }
}
