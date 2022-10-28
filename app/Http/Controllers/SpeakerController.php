<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    // API call use for fetching all the record for Modal Speaker Usecase
    public function all()
    {
        $data = Speaker::all();
        return response()->json($data, 200);

    }
}
