<?php

namespace App\Http\Controllers;

use App\Http\Resources\MediaResource;
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

    // API call use for fetching all the record for Modal Media Usecase
    public function all()
    {
        $data = Media::all();
        return MediaResource::collection($data);

    }

}
