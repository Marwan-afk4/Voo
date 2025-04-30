<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shakwa extends Model
{


    protected $fillable =[
        'user_id',
        'event_id',
        'task_id',
        'shakwa_title',
        'shakwa_description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
