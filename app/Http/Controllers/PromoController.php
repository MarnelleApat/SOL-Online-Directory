<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromoRequest;
use App\Models\Promo;

class PromoController extends Controller
{
    public function store(PromoRequest $request)
    {
        $promo = Promo::create($request->all());

        // return response()->json(['promo' => $promo], 200);
        return back()->with('message', 'Promo successfully added');
    }
}
