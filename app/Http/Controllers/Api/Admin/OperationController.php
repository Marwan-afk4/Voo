<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventVolunteer;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class OperationController extends Controller
{

//EVENT DETAILS////////////////////////////


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
        $Validation = FacadesValidator::make($request->all(), [
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
        $validation = FacadesValidator::make($request->all(), [
            'status' => 'required|in:accepted,rejected,lost,attend'
        ]);
        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors()
            ], 422);
        }

        // Find the volunteer record for that user
        $volunteerRecord = EventVolunteer::where('user_id', $volunteerId)->first();

        if ($volunteerRecord) {
            $volunteerRecord->status = $request->status;
            $volunteerRecord->save();

            return response()->json([
                'message' => 'Volunteer status updated successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'Volunteer not found'
            ], 404);
        }
    }


}


