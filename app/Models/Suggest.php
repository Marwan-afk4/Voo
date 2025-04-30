<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggest extends Model
{


    protected $fillable =[
        'user_id',
        'suggest_title',
        'suggest_description',
        'task_id',
        'event_id',
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

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
