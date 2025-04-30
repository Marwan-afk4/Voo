<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskRequirment extends Model
{


    protected $fillable =[
        'task_id',
        'requirment'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
