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
        ->with([
            'to_zone:id,name,city_id,country_id',
            'from_zone:id,name,city_id,country_id',
            'to_zone.city:id,name,country_id',
            'from_zone.city:id,name,country_id',
            'to_zone.city.country:id,name',
            'from_zone.city.country:id,name',
        ])->get();

        $acceptedRequest = ModelsRequest::where('user_id', $user->id)->count();
        $pendingRequest = ModelsRequest::where('user_id', $user->id)->where('status', 'pending')->count();
        $rejectedRequest = ModelsRequest::where('user_id', $user->id)->where('status', 'rejected')->count();


        return response()->json([
            'Allevents' => $Allevents,
            'tasks' => $tasks,
            'acceptedRequest' => $acceptedRequest,
            'pendingRequest' => $pendingRequest,
            'rejectedRequest' => $rejectedRequest,
        ])->setStatusCode(200, 'Success');
    }




}
