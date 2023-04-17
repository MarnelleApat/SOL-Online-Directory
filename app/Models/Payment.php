<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'program_payments';

    protected $fillable = [
        'programCode',
        'type',
        'details',
        'status',
    ];

    public $timestamps = false;

    public function event()
    {
        return $this->belongsTo(Event::class, 'programCode');
    }




}
