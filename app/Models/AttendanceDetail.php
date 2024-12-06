<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'student',
        'type',
        'sys_d_id',
        'parent_phone',
        'user_phone',
        'sms_status',
    ];

    public function get_section_details(){
        return $this->belongsTo(SchoolYearSectionDetails::class, 'sys_d_id');
    }

    public function get_attendance(){
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }
}
