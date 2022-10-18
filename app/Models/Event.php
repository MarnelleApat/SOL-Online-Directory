<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'slug',
        'department_id',
        'programCode',
        'title',
        'description',
        'checkHandler',
        'eventIncharge',
        'schedule',
        'activeUntil',
        'price',
        'venue',
        'limit',
        'isPublic',
        'email',
        'specialSettings',
        'type',
        'isActive',
        'status',
        'hasPromo',
        'totalRegistrants',
        'thumbnail',
        'banner',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_event', 'event_id', 'category_id');
    }

    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'event_speaker', 'event_id', 'speaker_id');
    }


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
