<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'event_schedules';

    protected $fillable = [
        'event_id',
        'date',
        'startTime',
        'endTime'
    ];


    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}
