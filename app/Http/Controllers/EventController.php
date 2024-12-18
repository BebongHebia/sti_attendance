<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function add_event(Request $request){
        Event::create([
            'event' => $request->event,
            'description' => $request->description,
            'date' => $request->date,
            'place' => $request->place,
            'status' => 'Incoming',
        ]);

        return response()->json();
    }

    public function edit_event(Request $request){
        $event = Event::find($request->event_id);
        $event->event = $request->event;
        $event->description = $request->description;
        $event->date = $request->date;
        $event->place = $request->place;
        $event->status = $request->status;
        $event->save();

        return response()->json();
    }

    public function delete_event(Request $request){
        $event = Event::find($request->event_id);
        $event->delete();

        return response()->json();
    }
}
