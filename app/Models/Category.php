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

    public function events() {
        return $this->belongsToMany(Event::class, 'category_event', 'event_id', 'category_id');
    }

}
