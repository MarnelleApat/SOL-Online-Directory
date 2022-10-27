<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'event_schedules';

    protected $fillable = [
        'id',
        'event_id',
        'date',
        'startTime',
        'endTime',
        'created_at',
        'updated_at'
    ];


    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}
