<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskBenfit extends Model
{


    protected $fillable =[
        'task_id',
        'benfit'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function task(){
        return $this->belongsTo(Task::class);
    }
}
