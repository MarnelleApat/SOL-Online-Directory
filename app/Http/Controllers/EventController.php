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
use stdClass;

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
                        'date' => $schedule['date'],
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
    public function updateRecord($event_id, Request $request)
    {

        // Check validation
        $dynamicValidation = [];

        if($request->columnName == 'activeUntil')
            $dynamicValidation = ['newData' => "required|date"];
        elseif($request->columnName == 'email')
            $dynamicValidation = ['newData' => "required|email"];
        elseif($request->columnName == 'price' || $request->columnName == 'limit')
            $dynamicValidation = ['newData' => "required|numeric|min:0"];
        elseif($request->columnName == 'venue')
        {
            $dynamicValidation = [
                'type'       => "required",
                'location'   => ($request->type == 'Physical' || $request->type == 'Hybrid') ? "required" : "",
                'city'       => ($request->type == 'Physical' || $request->type == 'Hybrid') ? "required" : "",
                "postalcode" => ($request->type == 'Physical' || $request->type == 'Hybrid') ? "required" : "",
                'url'        => ($request->type == 'Online' || $request->type == 'Hybrid') ? "required|url" : "",
                'meetingID'  => ($request->type == 'Online' || $request->type == 'Hybrid') ? "required" : "",
                "passcode"   => ($request->type == 'Online' || $request->type == 'Hybrid') ? "required" : ""
            ];
        }

        else
            $dynamicValidation = ['newData' => "required"];

        $request->validate($dynamicValidation);

        // find the Event and continue the updating
        $event = Event::find($event_id);

        if($request->columnName == 'thumbnail' || $request->columnName == 'banner' )
        {
            $event->update([$request->columnName => $request->newData['file_name']]);
            return redirect()->route('event.profile', $event->slug)
                             ->with('message', 'Image updated successfully.');
        }
        elseif($request->columnName == 'venue')
        {
            $venue = [
                'location'   => $request->location,
                'city'       => $request->city,
                "postalcode" => $request->postalcode,
                'url'        => $request->url,
                'meetingID'  => $request->meetingID,
                "passcode"   => $request->passcode
            ];

            $event->update(['type' => $request->type, 'venue' => json_encode($venue)]);
                return redirect()->route('event.profile', $event->slug);
        }
        else
        {
            $event->update([$request->columnName => $request->newData]);
                return redirect()->back();
        }


        if($request->columnName == 'thumbnail' || $request->columnName == 'banner' )
        {
            $newData = $request->newData['file_name'];
            $event->update([$request->columnName => $newData]);
            return response()->json($event, 200);
        }
        elseif($request->columnName == 'schedules')
        {
            if($request->newData)
            {
                // destroy/delete all the existing schedule of the event
                Schedule::where('event_id', $request->event_id)->delete();

                // insert new schedule data of the event
                foreach($request->newData as $schedule)
                {
                    Schedule::create([
                        'event_id' => $request->event_id,
                        'date' => $schedule['date'],
                        'startTime' => $schedule['startTime'],
                        'endTime' => $schedule['endTime'],
                    ]);
                }
            }
            return response()->json($event, 200);
        }
        elseif($request->columnName == 'categories')
        {
            if($request->newData)
            {
                $cat_ids = [];

                foreach($request->newData as $category)
                {
                    array_push($cat_ids, $category['id']);
                }

                $event->categories()->sync($cat_ids);
            }
            return response()->json($event, 200);
        }
        elseif($request->columnName == 'speakers')
        {
            if($request->newData)
            {
                $spkr_id = [];

                foreach($request->newData as $speaker)
                {
                    array_push($spkr_id, $speaker['id']);
                }

                $event->speakers()->sync($spkr_id);
            }
            return response()->json($event, 200);
        }
        else
            $newData = $request->newData;

        $event->update([$request->columnName => $newData]);
        return response()->json($event, 200);
    }
}
