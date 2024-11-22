<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'event',
        'date',
        'place',
        'att_type',
    ];

    public function get_event(){
        return $this->belongsTo(Event::class, 'event_id');
    }
}
