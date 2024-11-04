<?php

namespace App\Http\Controllers;

use App\Models\SySection;
use Illuminate\Http\Request;

class SySectionController extends Controller
{
    public function add_section(Request $request){
        SySection::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'grade_lvl' => $request->grade_lvl,
            'school_year' => $request->school_year,
            'status' => 'Active',
        ]);

        return response()->json();
    }

    public function edit_section(Request $request){
        $section = SySection::find($request->section_id);
        $section->section_name = $request->section_name;
        $section->description = $request->description;
        $section->grade_lvl = $request->grade_lvl;
        $section->school_year = $request->school_year;
        $section->status = $request->status;
        $section->save();
        return response()->json();

    }

    public function delete_section(Request $request){
        $section = SySection::find($request->section_id);
        $section->delete();
        return response()->json();
    }
}
