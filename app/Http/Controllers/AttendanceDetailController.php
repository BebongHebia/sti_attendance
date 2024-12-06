<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\AttendanceDetail;
use App\Models\SchoolYearSectionDetails;

class AttendanceDetailController extends Controller
{
    public function delete_att_de(Request $request){
        $att_details = AttendanceDetail::find($request->att_d_id);
        $att_details->delete();
        return response()->json();
    }

    public function add_attendee(Request $request){
        $get_attendance = Attendance::find($request->attendance_id);
        $get_student_section_details = SchoolYearSectionDetails::find($request->sys_d_id);

        AttendanceDetail::create([
            'attendance_id' => $get_attendance->id,
            'student' => $get_student_section_details->get_student->system_no,
            'type' => $get_attendance->att_type,
            'sys_d_id' => $get_student_section_details->id,
            'parent_phone' => $get_student_section_details->get_student->parent_contact,
            'user_phone' => $get_student_section_details->get_student->phone,
            'sms_status' => 'Pending',
        ]);

        return response()->json();
    }
}
