<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplyController extends Controller
{


    public function applyFor(Request $request){
        $user_id = $request->user()->id;
        $validation = Validator::make($request->all(), [
            'task_id' => 'nullable|exists:tasks,id',
            'event_id' => 'nullable|exists:events,id',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
        $task = Task::find($request->task_id);
        $event = Event::find($request->event_id);


        if($task){
            if ($task->number_of_voo_needed <= 0) {
                return response()->json(['message' => 'No more volunteers needed for this task'], 422);
            }
            $task->task_volunteers()->create([
                'user_id' => $user_id,
                'task_id' => $task->id,
                'hours' => $task->task_hours,
            ]);
            // $task->increment('number_of_voo_needed', -1);
        }
        elseif($event){
            if ($event->available_volunteers <= 0) {
                return response()->json(['message' => 'No more volunteers needed for this event'], 422);
            }
            $event->event_volunteers()->create([
                'user_id' => $user_id,
                'event_id' => $event->id,
                'hours' => $event->event_hours,
            ]);
            // $event->increment('number_of_voo_needed', -1);
        }
        return response()->json([
            'message' => 'Applied successfully',
        ]);

    }
}
