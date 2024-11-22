<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYearSectionDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'sys_id',

    ];


    function get_student(){
        return $this->belongsTo(User::class, 'student_id');
    }
}
