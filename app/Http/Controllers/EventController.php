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
            ->paginate();

        return Inertia::render('Events/index', [
            'events' => $events
        ]);
    }

    public function create()
    {
        return Inertia::render('Events/create');
    }
}
