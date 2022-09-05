<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'id',
        'order_id',
        'event_course_id',
        'price',
        'quantity', 
        'amount', 
        'promo_id', 
        'discount',
        'created_at',
        'updated_at' 
    ];
    
}
