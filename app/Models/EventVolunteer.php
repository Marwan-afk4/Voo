<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventVolunteer extends Model
{


    protected $fillable = [
        'event_id',
        'user_id',
        'role',
        'hours',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
