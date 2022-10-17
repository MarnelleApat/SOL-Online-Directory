<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Category;
use App\Models\Department;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\Speaker;
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
            ->with('user')
            ->paginate(7);


        return Inertia::render('Events/index', [
            'events' => $events
        ]);
    }

    public function store(EventRequest $request)
    {
        $event = $request->all();

        dd($event);

        // return Inertia::render('Events/create',[
        //     'events' => $event,
        // ]);

    }

    public function create()
    {
        $categories = Category::all();
        $departments = Department::all();
        $speakers = Speaker::all();

        return Inertia::render('Events/create',[
            'categories' => $categories,
            'departments'=> $departments,
            'speakers'=> $speakers
        ]);
    }

    public function profile( $slug )
    {
        $event = Event::where('slug', $slug)
            ->with('department')
            ->with('categories')
            ->with('user')
            ->first();

        return Inertia::render('Events/profile', [
            'event' => $event
        ]);
    }
}
