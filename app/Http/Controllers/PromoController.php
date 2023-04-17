<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromoRequest;
use App\Models\Promo;
use Carbon\Carbon;
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

    public function validatePromo($programCode, $promocode)
    {
        $now = date('Y-m-d');

        //Promo verification
        $promo = Promo::where('promoCode', $promocode)
            ->where('programCode', $programCode)
            ->whereDate('validFrom', '<=', $now)
            ->whereDate('validTo', '>=', $now)
            ->first();

        if($promo)
        {
            return response()->json(['status'=>true, 'message'=>'success', 'promo'=>$promo], 200);
        }

        return response()->json(['status'=>false, 'message'=>'Promo code is not valid', 'promo'=>$promo], 404);

    }
}
