<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentStudent extends Model
{
    use HasFactory;

    protected $fillable = [

        'sy_section',
        'parent_id',
        'student_id',

    ];

    public function get_sy_section(){
        return $this->belongsTo(SySection::class, 'sy_section');
    }

    public function get_parent(){
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function get_student_section(){
        return $this->belongsTo(SchoolYearSectionDetails::class, 'student_id');
    }

}
