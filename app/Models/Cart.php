<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'id',
        'event_course_id',
        'user_id', 
        'price', 
        'quantity',
        'amount',
        'promo_id',
        'discount',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    
} 