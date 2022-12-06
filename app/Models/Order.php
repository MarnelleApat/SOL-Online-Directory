<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customer_id',
        'orderNumber',
        'productCode',
        'price',
        'promo_id',
        'discount',
        'TrxID',
        'externalURL',
        'paymentType',
        'paymentReferenceNo',
        'approvedBy',
        'customFields',
        'status',
        'created_at',
        'updated_at'
    ];
}
