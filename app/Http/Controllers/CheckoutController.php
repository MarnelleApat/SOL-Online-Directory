<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index()
    {
        return Inertia::render('Checkout/index', []);
    }

    public function confirmCheckout( Request $request )
    {

        try
        {
            // check if it is confirm checkout or not
            // if the $_paymentType variable is set, -> it is checkout confirmation
            // Otherwise, it is just viewing the cart items ready for checkout
            $_paymentType = \Request::get('paymentType');
            $orderDetails = \Request::get('orderDetails');


            if(!$orderDetails)
                return redirect()->route('checkout.index');

            if($_paymentType)
            {
                $items = json_decode($orderDetails['items']);

                $_items = [];
                $gTotal = 0;

                foreach ($items as $key => $item)
                {

                    $_price = $item->price > 0 ? $item->price : 'FREE';

                    array_push($_items, [
                        'title'         => $item->title,
                        'slug'          => $item->slug,
                        'programCode'   => $item->programCode,
                        'price'         => $item->price,
                        'discount'      => $item->discount,
                        'promo_id'     => $item->promo_id,
                        'thumbnail'     => $item->thumbnail,
                        'netTotal'      => $item->price - ($item->discount ? $item->discount : 0),
                        'registrant'    => $item->registrant
                    ]);

                    $gTotal += $item->price - ($item->discount ? $item->discount : 0);
                }

                return Inertia::render('Checkout/Confirm', [
                    'PaymentType' => $_paymentType,
                    'items' => $_items,
                    'GrandTotal' => $gTotal
                ]);
            }

            return redirect()->route('checkout.index');
        }
        catch(Exception $e)
        {
            return redirect()->back();
        }
    }

}
