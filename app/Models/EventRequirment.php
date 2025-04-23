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

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
