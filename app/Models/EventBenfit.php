<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventBenfit extends Model
{


    protected $fillable =[
        'event_id',
        'benfit',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
