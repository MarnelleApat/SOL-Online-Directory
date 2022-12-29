<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use App\Models\Order;
use App\Models\Promo;
use Stripe\StripeClient;
use Illuminate\Http\Request;
use App\Services\PaymentGateway;

class OrderController extends Controller
{
    public function generateOrderNumberForEvent($event_id) : string
    {

        // get the event data
        $event = Event::find($event_id);

        // get the event programCode
        $programCode = $event->programCode;

        // update the totalRegistrants column (increment by 1)
        $event->increment('totalRegistrants');

        // increment the totalRegistrant then concatinate to the programCode
        return $programCode .'-'. sprintf('%03d', $event->totalRegistrants);
    }

    public function store(Request $request)
    {
        #Generate unique RegistrationCode of the customer to the event by concatinating the EventProgramCode and Event totalRegistrant value
        $order = Order::create([
            'customer_id' => $request->customer['id'],
            'orderNumber' => (new OrderController)->generateOrderNumberForEvent($request->event['id']),
            'productCode' => $request->event['programCode'],
            'price' => $request->event['price'],
            'promo_id' => (!empty($request->promoApplied) && $request->promoApplied['status']) ? $request->promoApplied['promo']['id'] : null,
            'discount' => (!empty($request->promoApplied) && $request->promoApplied['status']) ? $request->promoApplied['promo']['discountPrice'] : 0,
            'TrxID' => '',
            'externalURL' => '',
            'paymentType' => $request->paymentType,
            'paymentReferenceNo' => '',
            'approveBy' => '',
            'customFields' => json_decode($request->event['specialSettings'], true)[1],
            'status' => 'PENDING'
        ]);

        // increment the counting of the Promo code use during checkout (execute only if there is promocode)
        if($order && (!empty($request->promoApplied) && $request->promoApplied['status']))
        {
            $promo = Promo::find($request->promoApplied['promo']['id']);
            $promo->increment('consumedQty');
        }

        // execute payment after successfully storing the Order
        if($order)
        {
            $payment = new PaymentGateway($request->paymentType);
            $checkoutSession = $payment->processPayment($request, $order);
            return response('', 409)->header('X-Inertia-Location', $checkoutSession->url);
        }

        #Process Payment
    }

    /**
     * Route to redirect after the stripe payment success
     */
    public function success()
    {
        // Find the order of the client thru 'order_number'
        $orderNumber = $_GET['order_number'];

        $order = Order::where('orderNumber', $orderNumber);

        dd($order);

        $session_id = $_GET['session_id'];

        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $session = $stripe->checkout->sessions->retrieve($session_id);



        return Inertia::render('Homepage/Success', [
            'session' => $session
        ]);
    }

    /**
     * Rotue to redirect once the user cancel or press back the checkout session
     */
    public function cancel()
    {
        return Inertia::render('Homepage/Cancel');
    }
}
