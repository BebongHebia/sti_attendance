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
        'section_id',

    ];

}
