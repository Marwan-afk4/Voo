<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Request as ModelsRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class HomePageController extends Controller
{


    public function getEventsAndTaks(Request $request){
        $user = $request->user();
        $userOrgnizationId = $user->orgnization_id;
        $Allevents = Event::where('status', 'active')
            ->whereDoesntHave('event_volunteers', function($query) use($request){
                $query->where('user_id', $request->user()->id);
            })
            ->with([
            'city:id,name,country_id',
            'country:id,name',
            'zone:id,name,country_id,city_id',
            'event_benfits:id,event_id,benfit,status',
            'event_requirments:id,event_id,requirment,status',
        ])
            ->get();


        $tasks = Task::where('orgnization_id', $userOrgnizationId)
        ->where('status', 'active')
        ->whereDoesntHave('task_volunteers', function($query) use($request){
            $query->where('user_id', $request->user()->id);
        })
        ->with([
            'to_zone:id,name,city_id,country_id',
            'from_zone:id,name,city_id,country_id',
            'to_zone.city:id,name,country_id',
            'from_zone.city:id,name,country_id',
            'to_zone.city.country:id,name',
            'from_zone.city.country:id,name',
            'task_requirments:id,task_id,requirment',
            'task_benfits:id,task_id,benfit',
        ])->get();

        $acceptedRequest = ModelsRequest::where('user_id', $user->id)->where('status', 'accepted')->count();
        $pendingRequest = ModelsRequest::where('user_id', $user->id)->where('status', 'pending')->count();
        $rejectedRequest = ModelsRequest::where('user_id', $user->id)->where('status', 'rejected')->count();
        $lostRequest = ModelsRequest::where('user_id', $user->id)->where('status', 'lost')->count();
        $attendedRequest = ModelsRequest::where('user_id', $user->id)->where('status', 'attend')->count();


        return response()->json([
            'Allevents' => $Allevents,
            'tasks' => $tasks,
            'acceptedRequest' => $acceptedRequest,
            'pendingRequest' => $pendingRequest,
            'rejectedRequest' => $rejectedRequest,
            'lostRequest' => $lostRequest,
            'attendedRequest' => $attendedRequest,
        ])->setStatusCode(200, 'Success');
    }




}
