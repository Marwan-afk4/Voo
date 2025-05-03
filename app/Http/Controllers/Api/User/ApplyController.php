<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Request as ModelsRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplyController extends Controller
{


    public function applyFor(Request $request)
{
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

    if ($task) {
        if ($task->number_of_voo_needed <= 0) {
            return response()->json(['message' => 'No more volunteers needed for this task'], 422);
        }
        $task->update([
            'apply' => 1
        ]);

        $task->task_volunteers()->create([
            'user_id' => $user_id,
            'task_id' => $task->id,
            'hours' => $task->task_hours,
        ]);

        // ✅ Create corresponding request record
        ModelsRequest::create([
            'user_id'        => $user_id,
            'task_id'        => $task->id,
            'orgnization_id' => $task->orgnization_id ?? null,
            'request_type'   => 'task',
            'status'         => 'pending',
        ]);
    } elseif ($event) {
        if ($event->available_volunteers <= 0) {
            return response()->json(['message' => 'No more volunteers needed for this event'], 422);
        }

        $event->update([
            'apply' => 1
        ]);
        $event->event_volunteers()->create([
            'user_id' => $user_id,
            'event_id' => $event->id,
            'hours' => $event->event_hours,
        ]);

        // ✅ Create corresponding request record
        ModelsRequest::create([
            'user_id'        => $user_id,
            'event_id'       => $event->id,
            'orgnization_id' => $event->orgnization_id ?? null,
            'request_type'   => 'event',
            'status'         => 'pending',
        ]);
    }

    return response()->json([
        'message' => 'Applied successfully',
    ]);
}


//// 34an hamata

    public function OrginizationList(){
        $orgnization = User::where('role', 'organization')
        ->with(['country:name,id', 'city:name,id',])->get();
        $data =[
            'orgnization' => $orgnization,
        ];
        return response()->json($data, 200);
    }

}
