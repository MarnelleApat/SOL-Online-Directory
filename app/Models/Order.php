<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'TrxID',
        'programCode',
        'customer_id',
        'orderNumber',
        'amount',
        'promo_id',
        'discount',
        'paymentType',
        'externalURL',
        'paymentReferenceNo',
        'approvedBy',
        'customFields',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'customFields' => 'array',
    ];

    public function promo()
    {
        return $this->has(Promo::class);
    }

    // public function items()
    // {
    //     return $this->hasMany(OrderItem::class);
    // }
}
