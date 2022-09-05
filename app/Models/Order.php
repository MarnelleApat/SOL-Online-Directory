<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'id',
        'user_id',
        'TrxID',
        'externalURL',
        'paymentType',
        'paymentReferenceNo',
        'approvedBy',
        'created_at',
        'updated_at'  
    ];
    
}
