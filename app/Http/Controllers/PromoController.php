<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromoRequest;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function store(PromoRequest $request)
    {
        $promo = Promo::create([
            'event_id'   => $request->event_id,
            'name'       => $request->name,
            'promoCode'  => $request->promoCode,
            'description'=> $request->description,
            'quantity'   => $request->quantity,
            'validFrom'  => $request->validFrom,
            'validTo'    => $request->validTo,
        ]);
        return redirect()->back();
    }

    public function update($promo_id, Request $request)
    {
        $request->validate([
            'name'       => 'required',
            'description'=> 'required',
            'quantity'   => 'required|numeric|min:0',
            'validFrom'  => 'required|date',
            'validTo'    => 'required|date',
        ]);

        $promo = Promo::find($promo_id);
        $promo->update([
            'name'       => $request->name,
            'description'=> $request->description,
            'quantity'   => $request->quantity,
            'validFrom'  => $request->validFrom,
            'validTo'    => $request->validTo,
        ]);
        return redirect()->back();
    }
}
