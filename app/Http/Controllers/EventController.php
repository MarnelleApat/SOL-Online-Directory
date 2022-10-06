<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Inertia\Inertia;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('department')->paginate();

        return Inertia::render('Events/index', [
            'events' => $events
        ]);
    }

    public function create()
    {
        return Inertia::render('Events/create');
    }
}
