<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskRequirment extends Model
{


    protected $fillable =[
        'task_id',
        'requirment'
    ];

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
