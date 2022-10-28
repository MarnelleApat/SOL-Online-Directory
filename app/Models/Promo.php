<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promos';

    protected $fillable = [
        'id',
        'event_id',
        'name',
        'promoCode',
        'description',
        'quantity',
        'validFrom',
        'validTo',
        'created_at',
        'updated_at'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}
