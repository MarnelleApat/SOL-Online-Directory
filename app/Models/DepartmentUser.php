<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'department_user';

    protected $fillable = [
        'department_id',
        'user_id',
    ];
}
