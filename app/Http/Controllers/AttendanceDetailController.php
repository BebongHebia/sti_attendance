<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceDetail;

class AttendanceDetailController extends Controller
{
    public function delete_att_de(Request $request){
        $att_details = AttendanceDetail::find($request->att_d_id);
        $att_details->delete();
        return response()->json();
    }
}
