<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $medias = Media::paginate(10);
        return Inertia::render('Media/index', [
            'medias' => $medias
        ]);
    }
}
