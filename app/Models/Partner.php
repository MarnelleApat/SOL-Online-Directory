<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'partners';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'websiteUrl',
        'status',
        'created_at',
        'updated_at'
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'partner_user', 'partner_id', 'user_id');
    }
}
