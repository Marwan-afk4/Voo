<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Task;
use Illuminate\Http\Request;

class HomePageController extends Controller
{


    public function getEventsAndTaks(Request $request){
        $user = $request->user();
        $userOrgnizationId = $user->orgnization_id;
        $Allevents = Event::with([
            'city:id,name,country_id',
            'country:id,name',
            'zone:id,name,country_id,city_id',
            'event_benfits:id,event_id,benfit,status',
            'event_requirments:id,event_id,requirment,status',
            'event_volunteers:id,event_id,role,user_id',
            'event_volunteers.user:id,name,email,phone'
        ])
            ->get();
        $dataEvent = [
            'Allevents' => $Allevents,
        ];

        $tasks = Task::where('orgnization_id', $userOrgnizationId)->with([
            'to_zone:id,name,city_id,country_id',
            'from_zone:id,name,city_id,country_id',
            'to_zone.city:id,name,country_id',
            'from_zone.city:id,name,country_id',
            'to_zone.city.country:id,name',
            'from_zone.city.country:id,name',
        ]);

        $dataTask = [
            'tasks' => $tasks,
        ];
        return response()->json([
            'events' => $dataEvent,
            'tasks' => $dataTask,
        ]);
    }


}
