<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'program_schedules';

    protected $fillable = [
        'programCode',
        'date',
        'startTime',
        'endTime',
    ];

    public $timestamps = false;

    public function event()
    {
        return $this->belongsTo(Event::class, 'programCode');
    }

}
