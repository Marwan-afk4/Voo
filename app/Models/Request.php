<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{


    protected $fillable= [
        'user_id',
        'task_id',
        'event_id',
        'orgnization_id',
        'request_type',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function orgnization()
    {
        return $this->belongsTo(User::class, 'orgnization_id');
    }
}
