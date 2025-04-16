<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VooHour extends Model
{


    protected $fillable = [
        'event_id',
        'regular_hour',
        'organizer_hour',
        'leader_hour',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
