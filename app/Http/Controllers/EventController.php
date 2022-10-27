<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use App\Services\Slug;
use App\Models\Speaker;
use App\Models\Category;
use App\Models\Department;
use App\Http\Requests\EventRequest;
use App\Models\Schedule;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {

        $events = Event::where('status', true)
            ->where('isActive', true)
            ->where('isPublic', true)
            ->orderBy('id', 'DESC')
            ->with('department')
            ->with('categories')
            ->with('schedules')
            ->with('user')
            ->paginate(7);


        return Inertia::render('Events/index', [
            'events' => $events
        ]);
    }

    public function store(EventRequest $request, Slug $slug, Event $event)
    {

        // proceed to insertion once all passed the validation
        $eventData = Event::create([
            'title' => $request->title,
            'department_id' => $request->department['id'],
            'slug'  => $slug->createSlug($request->title, $event),
            'programCode' => $request->programCode,
            'description' => $request->description,
            'checkHandler' => $request->checkHandler,
            'eventIncharge' => $request->personIncharge,
            'activeUntil' => $request->validity,
            'price' => $request->registrationFee,
            'venue' => json_encode($request->venue),
            'limit' => $request->limitReg,
            'email' => $request->emailIncharge,
            'type' => $request->eventType,
            'user_id' => Auth::user()->id,
            'thumbnail' => $request->photoImg['file_name'],
            'banner' => $request->banner['file_name'],
        ]);

        // after storing the Event record
        if($eventData)
        {
            // insert schedule check and store the schedule to the schedule table
            if($request->schedules)
            {
                foreach($request->schedules as $schedule) {
                    Schedule::create([
                        'event_id' => $eventData->id,
                        'date' => $schedule['startDate'],
                        'startTime' => $schedule['startTime'],
                        'endTime' => $schedule['endTime'],
                    ]);
                }
            }

            // inser categories => check and store the categories to the pivor table
            if($request->categories)
            {
                foreach($request->categories as $category) {
                    $eventData->categories()->attach($category['id']);
                }
            }

            // insert speakers => check and store the speakers to the pivor table
            if(count($request->speakers))
            {
                foreach($request->speakers as $speaker) {
                    $eventData->speakers()->attach($speaker['id']);
                }
            }
        }

        // redirect to Event Profile after the insertion
        return redirect()
            ->route('event.profile', $eventData->slug)
            ->with('message', 'Event created successfully. You can now add promos, additional settings and customize registration form');

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
            ->with('speakers')
            ->with('schedules')
            ->with('user')
            ->first();

        return Inertia::render('Events/profile', [
            'event' => $event
        ]);
    }


    // API Method => Update specific column in the event located at the Profile View
    public function updateRecord(Request $request, Event $event)
    {
        // validate and terminate process once failed
        if($request->newData == "") {
            return response()->json('Input cannot be empty.', 302);
        }

        // find the Event and continue the updating
        $event = Event::find($request->event_id);

        if($request->columnName == 'thumbnail' || $request->columnName == 'banner' )
            $newData = $request->newData['file_name'];
        elseif($request->columnName == 'venue')
        {
            $event->update(['type' => $request->newData[0], $request->columnName => $request->newData[1]]);
            return response()->json($event, 200);
        }
        else
            $newData = $request->newData;

        $event->update([$request->columnName => $newData]);

        return response()->json($event, 200);
    }
}
