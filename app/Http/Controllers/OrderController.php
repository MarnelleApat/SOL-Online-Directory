<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function generateOrderNumberForEvent($event_id) : string
    {

        // get the event data
        $event = Event::find($event_id);

        // get the event programCode
        $programCode = $event->programCode;

        // update the totalRegistrants column (increment by 1)
        $event->increment('totalRegistrants');

        // increment the totalRegistrant then concatinate to the programCode
        return $programCode .'-'. sprintf('%03d', $event->totalRegistrants);
    }
}
