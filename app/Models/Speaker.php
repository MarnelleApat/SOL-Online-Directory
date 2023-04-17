<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $table = 'speakers';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'email',
        'phoneNumber',
        'description',
        'profileImg',
        'created_at',
        'updated_at'
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class, 'program_speakers', 'speaker_id', 'programCode');
    }

}
