<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'crated_at',
        'updated_at'
    ];

    public function eventCourses() {
        return $this->belongsToMany(EventCourse::class, 'events_course_category', 'category_id', 'event_id');
    }

}
