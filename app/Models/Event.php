<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $primaryKey = 'programCode';
    protected $keyType = 'string';
    public $incrementing = false;


    protected $fillable = [
        'id',
        'slug',
        'partner_id',
        'programCode',
        'title',
        'description',
        'eventIncharge',
        'activeUntil',
        'price',
        'venue',
        'limit',
        'email',
        'specialSettings',
        'type',
        'isActive',
        'status',
        'totalRegistrants',
        'thumbnail',
        'banner',
        'user_id',
        'created_at',
        'updated_at'
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'program_categories', 'programCode', 'category_id');
    }

    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'program_speakers', 'programCode', 'speaker_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'programCode');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'programCode');
    }

    public function promos()
    {
        return $this->hasMany(Promo::class, 'programCode');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
