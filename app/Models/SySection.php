<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SySection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_name',
        'description',
        'grade_lvl',
        'school_year',
        'status',
    ];
}
