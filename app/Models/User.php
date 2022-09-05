<?php

namespace App\Models;

use App\Traits\FilterByTenant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    // use FilterByTenant;

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'niceName',
        'email',
        'username',
        'password',
        'firstName',
        'lastName',
        'nirc',
        'phoneNumber',
        'address',
        'city',
        'postalCode',
        'country',
        'church',
        'billingAddress',
        'ShippingAddress',
        'isActive',
        'userType',
        'status',
        'current_tenant_id'
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_user', 'user_id', 'department_id');
    }

    public function tenants()
    {
        return $this->belongsToMany(Tenant::class);
    }
}
