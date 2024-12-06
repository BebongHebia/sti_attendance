<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParentStudent;

class ParentStudentController extends Controller
{
    public function add_parent_student(Request $request){
        ParentStudent::create([
            'sy_section' => $request->sy_section,
            'parent_id' => $request->parent_id,
            'student_id' => $request->student_id,
        ]);

        return response()->json();
    }

    public function remove_parent_student(Request $request){
        $get_parent_student = ParentStudent::find($request->parent_student_id);
        $get_parent_student->delete();
        return response()->json();
    }
}
