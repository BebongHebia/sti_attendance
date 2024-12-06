<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\SchoolYearSectionDetails;

class AttendanceController extends Controller
{
    public function add_attendance(Request $request){
        Attendance::create([
            'event_id' => $request->event_id,
            'event' => $request->event,
            'date' => $request->date,
            'place' => $request->place,
            'att_type' => $request->att_type,
            'day' => $request->day,
        ]);

        return response()->json();
    }

    public function edit_attendance(Request $request){
        $att = Attendance::find($request->att_id);
        $att->att_type = $request->att_type;
        $att->day = $request->day;
        $att->save();

        return response()->json();
    }

    public function delete_attendance(Request $request){
        $att = Attendance::find($request->att_id);
        $att->delete();

        return response()->json();
    }


}
