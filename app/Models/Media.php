<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'type',
        'meta_data',
        'created_at',
        'updated_at'
    ];
}
