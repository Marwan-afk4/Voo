<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRequirment extends Model
{


    protected $fillable =[
        'event_id',
        'requirment',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
