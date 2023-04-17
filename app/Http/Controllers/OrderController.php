<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Customer;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use App\Services\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class OrderController extends Controller
{
    public function generateOrderNumberForEvent($programCode) : string
    {

        $event = Event::where('programCode', $programCode)->first(); // get the event

        $_programCode = $event->programCode; // get the event programCode

        $event->increment('totalRegistrants'); // update the totalRegistrants column (increment by 1)

        return $_programCode .'-'. sprintf('%03d', $event->totalRegistrants); // increment the totalRegistrant then concatinate to the programCode

    }

    public function store(Request $request)
    {
        /**
        * Registration Process
        * 1. check if it is guest checkout
        * 2. if guest checkout -> create a customer account. Email address is unique, if exist, update other details otherwise create a customer account. Then use the customer_id to create order record
        * 3. If Authenticated, create order record outrigth.
        *
         */

        // check if guest checkout

        // Guest checkout
        if(!Auth::user())
        {
            foreach ($request->cartItems as $key => $item)
            {

                #CREATE CUSTOMER RECORD |  create or update customer account
                $customer = Customer::updateOrCreate(
                    [
                        'email' => $item['registrant']['email']
                    ],
                    [
                        'nirc'          => $item['registrant']['nirc'],
                        'email'         => $item['registrant']['email'],
                        'firstName'     => $item['registrant']['firstName'],
                        'lastName'      => $item['registrant']['lastName'],
                        'phoneNumber'   => $item['registrant']['phoneNumber'],
                        'address'       => $item['registrant']['address'],
                        'city'          => $item['registrant']['city'],
                        'postalCode'    => $item['registrant']['postalCode'],
                        'country'       => $item['registrant']['country'],
                        'gender'        => $item['registrant']['gender'],
                        'church'        => $item['registrant']['church'],
                    ]
                );

                #CREATE ORDER RECORD | Generate unique RegistrationCode of the customer to the event by concatinating the EventProgramCode and Event totalRegistrant value
                $order = Order::create([
                    'TrxID'                 => 'CHK2023', // temporary (process here if group checkout)
                    'customer_id'           => $customer->id,
                    'orderNumber'           => (new OrderController)->generateOrderNumberForEvent($item['programCode']),
                    'amount'                => $item['price'],
                    'programCode'           => $item['programCode'],
                    'promo_id'              => $item['promo_id'],
                    'discount'              => $item['discount'] ? $item['discount'] : 0,
                    'externalURL'           => '',
                    'paymentType'           => $request->paymentType,
                    'paymentReferenceNo'    => 'CHK2023-TEST',
                    'approveBy'             => '',
                    'customFields'          => null,
                    // 'customFields'          => json_decode($request->event['specialSettings'], true)[1],
                    'status'                => 'PENDING'
                ]);


                #UPDATE PROMO RECORD (IF ANY) increment the counting of the Promo code use during checkout (execute only if there is promocode)
                if($order && !empty($item['promo_id']))
                {
                    $promo = Promo::find($item['promo_id']);
                    $promo->increment('consumedQty');
                }

                # // execute payment after successfully storing the Order
                if($order)
                {
                    if($request->paymentType == "cheque")
                    {
                        return redirect()->route('thankyou', ['trxnID' => $order->TrxID]);
                        // redirect to thankyour route as as http://domain.com/thankyou?trxnID=CHK2023
                    }
                    elseif($request->paymentType == "credit card")
                    {
                        dd($request->paymentType);

                        $payment = new PaymentGateway($request->paymentType);
                        $checkoutSession = $payment->processPayment($request, $order);
                        return response('', 409)->header('X-Inertia-Location', $checkoutSession->url);
                    }
                }


            }

        }
        // user logged-in checkout
        // else
        // {

        // }

    }

    /**
     * Route to redirect after the stripe payment success
     */
    public function success()
    {
        $session_id = $_GET['session_id'];

        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $session = $stripe->checkout->sessions->retrieve($session_id);
        $line_items = $stripe->checkout->sessions->allLineItems($session_id);

        return Inertia::render('Homepage/Success', [
            'session' => $session,
            'items' => $line_items
        ]);
    }

    /**
     * Rotue to redirect once the user cancel or press back the checkout session
     */
    public function cancel()
    {
        return Inertia::render('Homepage/Cancel');
    }

    /***
     * Thank You Page after checkout both card, checque payment
     */
    public function thankyou()
    {
        $trxnNo = \Request::get('trxnID');

        if($trxnNo)
        {
            $orders = Order::where('TrxID', $trxnNo)->get();

            if(count($orders))
            {
                // Remove all the checked out items in the local storage for Guest Checkout
                // Remove all the checked out items in the Cart Table in the DB of the logged-in customer/user
                // Send email to the customer about the successful registration.

                return Inertia::render('Homepage/Thankyou', [ 'orders' => $orders ]);
            }

            return redirect()->route('notFound');
        }
        else
        {
            return redirect()->route('notFound');
        }
    }

}
