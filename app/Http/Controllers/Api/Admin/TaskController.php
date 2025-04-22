<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{


    public function getTasks(){
        $tasks = Task::with(['to_zone:id,name,city_id,country_id','from_zone:id,name,city_id,country_id'])->get();
        $data =[
            'tasks' => $tasks,
        ];
        return response()->json($data, 200);
    }
}
