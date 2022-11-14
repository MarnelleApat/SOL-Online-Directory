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
            'specialSettings' => '[{"themeColor":"#2C2C2C"}, {"customFields": []}]'
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
            ->with('promos')
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
                return redirect()->back();
        }
        elseif($request->columnName == 'schedules')
        {
            if($request->newData)
            {
                //detach the existing schedule
                Schedule::where('event_id', $event_id)->delete();

                // insert the updated schedule data of the event
                foreach($request->newData as $schedule)
                {
                    Schedule::create([
                        'event_id' => $event_id,
                        'date' => $schedule['date'],
                        'startTime' => $schedule['startTime'],
                        'endTime' => $schedule['endTime'],
                    ]);
                }
            }
            return redirect()->back();
        }
        elseif($request->columnName == 'categories' || $request->columnName == 'speakers')
        {
            if($request->newData)
            {
                $data_ids = [];

                foreach($request->newData as $record)
                {
                    array_push($data_ids, $record['id']);
                }
                $request->columnName == 'categories'
                    ? $event->categories()->sync($data_ids)
                    : $event->speakers()->sync($data_ids);
            }
            return redirect()->back();
        }
        elseif($request->columnName == 'specialSettings')
        {
            $sp = json_decode($request->newData, true);
            $esp = json_decode($event->specialSettings, true);
            $customfields = $esp[1]['customFields'];

            $customfields = [];

            foreach ($sp as $_sp)
            {
                array_push($customfields, $_sp);
            }

            $esp[1]['customFields'] = $customfields;

            $event->update(['specialSettings' => json_encode($esp)]);
            return redirect()->back();
        }
        elseif($request->columnName == 'themeColor')
        {
            $newcolor = $request->newData;
            $esp = json_decode($event->specialSettings, true);

            $esp[0]['themeColor'] = $newcolor;

            $event->update(['specialSettings' => json_encode($esp)]);
            return redirect()->back();
        }
        else
        {
            $event->update([$request->columnName => $request->newData]);
                return redirect()->back();
        }
    }
}
