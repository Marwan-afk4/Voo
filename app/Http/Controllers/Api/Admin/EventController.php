<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{


    public function getEvents(){
        $events = Event::with([
            'city:id,name,country_id',
            'country:id,name',
            'zone:id,name,country_id,city_id',
            'event_benfits:id,event_id,benfit,status',
            'event_requirments:id,event_id,requirment,status',
            'event_volunteers:id,event_id,role,user_id',
            'event_volunteers.user:id,name,email,phone'
            ])
            ->get();
            $data =[
                'events' => $events,
            ];
        return response()->json($data);
    }
}
