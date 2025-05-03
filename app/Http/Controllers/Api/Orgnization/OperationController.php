<?php

namespace App\Http\Controllers\Api\Orgnization;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventVolunteer;
use App\Models\Shakwa;
use App\Models\Suggest;
use App\Models\Task;
use App\Models\TaskVolunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OperationController extends Controller
{
    public function getEventsDetails($eventId){
        $events = Event::with([
            'city:id,name,country_id',
            'country:id,name',
            'zone:id,name,country_id,city_id',
            'event_benfits:id,event_id,benfit,status',
            'event_requirments:id,event_id,requirment,status',
            'event_volunteers:id,event_id,role,user_id',
            'event_volunteers.user:id,name,email,phone',
            'orgnization'
        ])->find($eventId);
        if ($events) {
            return response()->json([
                'message' => 'Event details retrieved successfully',
                'data' => $events
            ]);
        } else {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }
    }

//TASK DETAILS//////////////////////////////


    public function getTasksDetails($taskId){
        $tasks = Task::with([
            'to_zone:id,name,city_id,country_id',
            'from_zone:id,name,city_id,country_id',
            'to_zone.city:id,name,country_id',
            'from_zone.city:id,name,country_id',
            'to_zone.city.country:id,name',
            'from_zone.city.country:id,name',
            'task_requirments',
            'task_benfits',
            'orgnization'
        ])->find($taskId);
        if ($tasks) {
            return response()->json([
                'message' => 'Task details retrieved successfully',
                'data' => $tasks
            ]);
        } else {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }
    }


//GET EVENT VOLUNTEERS////////////////////////////


    public function getEventVolunteers($eventId){
        $volunteers = Event::with([
            'event_volunteers',
            'event_volunteers.user:id,name,email,phone'
        ])->find($eventId);
        if ($volunteers) {
            return response()->json([
                'message' => 'Event volunteers retrieved successfully',
                'users' => $volunteers
            ]);
        } else {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }
    }


//GET TASK VOLUNTEERS////////////////////////////


    public function getTaskVolunteers($taskId){
        $volunteers = Task::with([
            'task_volunteers',
            'task_volunteers.user:id,name,email,phone'
        ])->find($taskId);
        if ($volunteers) {
            return response()->json([
                'message' => 'Task volunteers retrieved successfully',
                'data' => $volunteers
            ]);
        } else {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }
    }


// CHANGE Event VOOLUNTEER STATUS////////////////////////////


    public function changeEventVolunteerStatus(Request $request, $volunteerId)
    {
        $Validation = Validator::make($request->all(), [
            'status' => 'required|in:accepted,rejected,lost,attend'
        ]);
        if ($Validation->fails()) {
            return response()->json([
                'errors' => $Validation->errors()
            ], 422);
        }

        // Find the volunteer record for that user
        $volunteerRecord = EventVolunteer::where('user_id', $volunteerId)->first();

        if ($volunteerRecord) {
            $volunteerRecord->status = $request->status;
            $volunteerRecord->save();

        if($request->status == 'accepted'){
            $volunteerRecord->event->number_of_volunteers -= 1;
            $volunteerRecord->event->save();
        }

        if($request->status == 'attend'){
            $volunteerRecord->user->total_hours += $volunteerRecord->event->event_hours;
            $volunteerRecord->user->total_events += 1;
            $volunteerRecord->user->save();
        }

            return response()->json([
                'message' => 'Volunteer status updated successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Volunteer not found'
            ], 404);
        }
    }

// CHANGE TASK VOLUNTEER STATUS////////////////////////////


    public function changeTaskVolunteerStatus(Request $request, $volunteerId){
        $validation = Validator::make($request->all(), [
            'status' => 'required|in:accepted,rejected,lost,attend'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422);
        }

        // Find the volunteer record for that user
        $volunteerRecord = TaskVolunteer::where('user_id', $volunteerId)->first();

        if ($volunteerRecord) {
            $volunteerRecord->status = $request->status;
            $volunteerRecord->save();

            if($request->status == 'accepted'){
                $volunteerRecord->task->number_of_voo_needed -= 1;
                $volunteerRecord->task->save();
            }
            if($request->status == 'attend'){
                $volunteerRecord->user->total_hours += $volunteerRecord->task->task_hours;
                $volunteerRecord->user->total_tasks += 1;
                $volunteerRecord->user->save();
            }
            return response()->json([
                'message' => 'Volunteer status updated successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Volunteer not found'
            ], 404);
        }
    }

// GET EVENT SHAKWAT////////////////////////////

public function getEventShakwat($eventId){
    $eventShakwa = Shakwa::where('event_id', $eventId)
        ->with([
            'user:id,name,email,phone',
            'event:id,name,orgnization_id',
            'event.orgnization:id,name,email,phone'
        ])->get();
        if ($eventShakwa) {
            return response()->json([
                'message' => 'Event shakwat retrieved successfully',
                'data' => $eventShakwa
            ]);
        } else {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }
    }

// GET TASK SHAKWAT////////////////////////////

    public function getTaskShakwat($taskId){
        $taskShakwa = Shakwa::where('task_id', $taskId)
            ->with([
                'user:id,name,email,phone',
                'task:id,name,orgnization_id',
                'task.orgnization:id,name,email,phone'
            ])->get();
        if ($taskShakwa) {
            return response()->json([
                'message' => 'Task shakwat retrieved successfully',
                'data' => $taskShakwa
            ]);
        } else {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }
    }

// GET EVENT SUGGEST/////////////////////////////

    public function getEventSuggest($eventId){
        $eventSuggest = Suggest::where('event_id', $eventId)
            ->with([
                'user:id,name,email,phone',
                'event:id,name,orgnization_id',
                'event.orgnization:id,name,email,phone'
            ])->get();
        if ($eventSuggest) {
            return response()->json([
                'message' => 'Event suggest retrieved successfully',
                'data' => $eventSuggest
            ]);
        } else {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }
    }

// GET TASK SUGGEST/////////////////////////////

    public function getTaskSuggest($taskId){
        $taskSuggest = Suggest::where('task_id', $taskId)
            ->with([
                'user:id,name,email,phone',
                'task:id,name,orgnization_id',
                'task.orgnization:id,name,email,phone'
            ])->get();
        if ($taskSuggest) {
            return response()->json([
                'message' => 'Task suggest retrieved successfully',
                'data' => $taskSuggest
            ]);
        } else {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }
}

    public function ReadTaskSuggest($taskId){
        $taskSuggest = Suggest::where('task_id', $taskId)->first();
            if($taskSuggest){
                $taskSuggest->status = 'read';
                $taskSuggest->save();
            }
            if ($taskSuggest) {
            return response()->json([
                'message' => 'Task suggest retrieved successfully',
                'data' => $taskSuggest
            ]);
        } else {
            return response()->json([
                'message' => 'Task not found'
            ], 404);
        }
    }

    public function ReadEventSuggest($eventId){
        $eventSuggest = Suggest::where('event_id', $eventId)->first();
            if($eventSuggest){
                $eventSuggest->status = 'read';
                $eventSuggest->save();
            }
            if ($eventSuggest) {
            return response()->json([
                'message' => 'Event suggest retrieved successfully',
                'data' => $eventSuggest
            ]);
        } else {
            return response()->json([
                'message' => 'Event not found'
            ], 404);
        }
    }

}
