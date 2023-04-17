<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Event;
use App\Services\Slug;
use App\Models\Speaker;
use App\Models\Category;
use App\Models\Department;
use App\Http\Requests\EventRequest;
use App\Models\Partner;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    /**
     * Get all the lists of events in the ADMIN portal
     * Execution: 'Admin' Middleware
     */
    public function index()
    {
        $events = Event::orderBy('created_at', 'DESC')
            // ->with('partners')
            ->with('schedules')
            ->with('categories')
            ->paginate(8);

        return Inertia::render('Admin/Events/index',[
            'events' => $events
        ]);
    }

    /**
    * Search the event by title with the keyword inputted by the user
    * Execution: 'Admin' Middleware
    */
    public function searchEvents(Request $request)
    {
        if(!empty($request->keyword))
        {
            $events = Event::where('title', 'like', '%' . $request->keyword . '%')
                ->with('schedules')
                ->with('categories')
                ->paginate(8);

            return Inertia::render('Admin/Events/index',[
                'events' => $events,
            ]);
        }
        else
        {
            return redirect()->route('admin.events');
        }
    }

    /**
     * Get all the create/add new Event record in the ADMIN portal
     * Execution: 'Admin' Middleware
     */
    public function create()
    {

        $partners = Partner::all();
        $categories = Category::all();
        $speakers   = Speaker::all();

        return Inertia::render('Admin/Events/create',[
            'categories' => $categories,
            'partners'=> $partners,
            'speakers'=> $speakers,
            'user' => Auth::user()
        ]);
    }

    /**
     * Store the creation of new Event in the ADMIN portal
     * Execution: 'Admin' Middleware
     */
    public function store(EventRequest $request, Slug $slug, Event $event)
    {
        // dd($request->all());

        // proceed to insertion once all passed the validation
        $eventData = Event::create([
            'title'             => $request->title,
            'partner_id'        => $request->partner['id'],
            'slug'              => $slug->createSlug($request->title, $event),
            'programCode'       => $request->programCode,
            'description'       => $request->description,
            'eventIncharge'     => $request->personIncharge,
            'activeUntil'       => $request->validity,
            'price'             => $request->registrationFee,
            'venue'             => json_encode($request->venue),
            'limit'             => $request->limitReg,
            'email'             => $request->emailIncharge,
            'type'              => $request->eventType,
            'user_id'           => Auth::user()->id,
            'banner'            => $request->banner['file_name'],
            'specialSettings'   => '[{"customFields": []}]',
            'status'            => $request->isSaveAsDraft ? 'Draft' : 'Published'
        ]);

        // after storing the Event record
        if($eventData)
        {
            // insert schedule check and store the schedule to the schedule table
            if(count($request->schedules) > 0)
            {
                foreach($request->schedules as $schedule)
                {
                    $eventData->schedules()->create([
                        'date' => $schedule['date'],
                        'startTime' => $schedule['startTime'],
                        'endTime' => $schedule['endTime'],
                    ]);
                }
            }

            // insert categories => check and store the categories to the program_categories pivot table
            if(count($request->categories) > 0)
            {
                foreach($request->categories as $category) {
                    $eventData->categories()->attach($category['id']);
                }
            }

            // insert speakers => check and store the speakers to the pivor table
            if($request->speakers)
            {
                foreach($request->speakers as $speaker) {
                    $eventData->speakers()->attach($speaker['id']);
                }
            }

            // insert payment mode => check and store the payment mode set by the user during the creation.
            // By default, it is FREE event
            if(count($request->paymentMode))
            {
                foreach($request->paymentMode as $payment)
                {
                    $eventData->payments()->create([
                        'type' => $payment['type'],
                        'details' => $payment['details'],
                        'status' => $payment['status'],
                    ]);
                }
            }
        }

        // redirect to Event Profile after the insertion
        return to_route('admin.eventProfile', $eventData->slug)
            ->with('message', 'Event created successfully. You can now add promos, configure registration form & override special settings.');
    }

    /**
     * Get the Event Profile Page in the ADMIN portal
     * Execution: 'Admin' Middleware
     */
    public function eventProfile( $slug )
    {
        $event = Event::where('slug', $slug)
            ->with('partner')
            ->with('categories')
            ->with('speakers')
            ->with('promos')
            ->with('schedules')
            ->first();

        return Inertia::render('Admin/Events/update',[
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

    /**
     * ********************************************
     * Routes available for Public access.
     * * ********************************************
    */
    // Single Event Route (Event Landing Page)
    public function single($slug)
    {
        $event = Event::where('slug', $slug)
            ->with('partner')
            ->with('categories')
            ->with('speakers')
            ->with('promos')
            ->with('schedules')
            ->first();

        // dd($event);

        return Inertia::render('Homepage/SingleEvent', [
            'event' => $event
        ]);
    }

    // Events List
    public function list()
    {
        $events = Event::orderBy('created_at', 'DESC')
            ->with('partner')
            ->with('categories')
            ->with('speakers')
            ->with('promos')
            ->with('schedules')
            ->paginate(8);

        dd($events);

        return Inertia::render('Homepage/EventsList',[
            'events' => $events
        ]);
    }

    // Events List
    public function guestRegister($programCode)
    {
        $event = Event::where('programCode', $programCode)
            ->with('partner')
            ->with('categories')
            ->with('speakers')
            ->with('promos')
            ->with('schedules')
            ->first();

        return Inertia::render('Homepage/GuestRegister',[
            'event' => $event
        ]);
    }
}
