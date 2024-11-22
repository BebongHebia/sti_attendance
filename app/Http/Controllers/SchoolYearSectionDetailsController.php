<?php

namespace App\Http\Controllers;

use App\Models\SchoolYearSectionDetails;
use Illuminate\Http\Request;

class SchoolYearSectionDetailsController extends Controller
{
    public function add_sys_details(Request $request){
        SchoolYearSectionDetails::create([
            'student_id' => $request->student_id,
            'sys_id' => $request->sys_id,
        ]);

        return response()->json();
    }

    public function remove_sys_details(Request $request){
        $sys_details = SchoolYearSectionDetails::find($request->sys_d_id);
        $sys_details->delete();
        return response()->json();
    }
}
