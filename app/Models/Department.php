<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'websiteUrl',
        'status',
        'created_at',
        'updated_at'
    ];
    
    public function events()
    {
        return $this->hasMany(EventCourse::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'department_user', 'department_id', 'user_id');
    }
}
