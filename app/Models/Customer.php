<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'stripeCustomerCode',
        'nirc',
        'email',
        'firstName',
        'lastName',
        'phoneNumber',
        'address',
        'city',
        'postalCode',
        'country',
        'church',
        'billingAddress',
        'shippingAddress',
        'gender',
        'meta_data'
    ];

    protected $casts = [
        'billingAddress' => 'object',
        'shippingAddress' => 'object'
    ];

}
