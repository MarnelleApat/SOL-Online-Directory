<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('status', true)
            ->where('isActive', true)
            ->where('isPublic', true)
            ->with('department')
            ->with('categories')
            ->paginate(7);

        return Inertia::render('Events/index', [
            'events' => $events
        ]);
    }

    public function create()
    {
        return Inertia::render('Events/create');
    }

    public function profile( $slug )
    {
        $event = Event::where('slug', $slug)
            ->with('department')
            ->with('categories')
            ->first();

        return Inertia::render('Events/profile', [
            'event' => $event
        ]);
    }
}
