<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Image;
use App\Models\Event;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    use Image;

    public function getEvents()
    {
        $events = Event::with([
            'city:id,name,country_id',
            'country:id,name',
            'zone:id,name,country_id,city_id',
            'event_benfits:id,event_id,benfit,status',
            'event_requirments:id,event_id,requirment,status',
            'event_volunteers:id,event_id,role,user_id',
            'event_volunteers.user:id,name,email,phone',
            'orgnization'
        ])
            ->get();
        $data = [
            'events' => $events,
        ];
        return response()->json($data);
    }

    public function addEvent(EventRequest $request)
    {
        DB::beginTransaction();

        try {
            $event = Event::create([
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'zone_id' => $request->zone_id,
                'name' => $request->name,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'number_of_volunteers' => $request->number_of_volunteers,
                'available_volunteers' => $request->number_of_volunteers,
                'number_of_organizers' => $request->number_of_organizers,
                'location' => $request->location,
                'google_maps_location' => $request->google_maps_location,
                'description' => $request->description,
                'image' => $this->storeBase64Image($request->image, 'events/images'),
                'status' => $request->status,
            ]);

            foreach ($request->benfit as $benefit) {
                $event->event_benfits()->create([
                    'event_id' => $event->id,
                    'benfit' => $benefit['benfit'],
                    'status' => $benefit['status'],
                ]);
            }

            foreach ($request->requirment as $requirement) {
                $event->event_requirments()->create([
                    'event_id' => $event->id,
                    'requirment' => $requirement['requirment'],
                    'status' => $requirement['status'],
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Event created successfully',
                'data' => $event->load(['event_benfits', 'event_requirments'])
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create event',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getEventById($id)
    {
        $event = Event::with([
            'city:id,name,country_id',
            'country:id,name',
            'zone:id,name,country_id,city_id',
            'event_benfits:id,event_id,benfit,status',
            'event_requirments:id,event_id,requirment,status',
            'event_volunteers:id,event_id,role,user_id',
            'event_volunteers.user:id,name,email,phone'
        ])
            ->find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json($event);
    }


    public function updateEvent(EventRequest $request, $id)
{
    DB::beginTransaction();

    try {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Update event core fields
        $event->update([
            'country_id' => $request->country_id ?? $event->country_id,
            'city_id' => $request->city_id ?? $event->city_id,
            'zone_id' => $request->zone_id ?? $event->zone_id,
            'name' => $request->name ?? $event->name,
            'date' => $request->date ?? $event->date,
            'start_time' => $request->start_time ?? $event->start_time,
            'end_time' => $request->end_time ?? $event->end_time,
            'number_of_volunteers' => $request->number_of_volunteers ?? $event->number_of_volunteers,
            'available_volunteers' => $request->number_of_volunteers ?? $event->available_volunteers,
            'number_of_organizers' => $request->number_of_organizers ?? $event->number_of_organizers,
            'location' => $request->location ?? $event->location,
            'google_maps_location' => $request->google_maps_location ?? $event->google_maps_location,
            'description' => $request->description ?? $event->description,
            'image' => $request->image ? $this->storeBase64Image($request->image, 'events/images') : $event->image,
            'status' => $request->status ?? $event->status,
        ]);

        // ✅ Delete old benefits and insert new ones
        $event->event_benfits()->delete();
        foreach ($request->benfit as $benefit) {
            $event->event_benfits()->create([
                'benfit' => $benefit['benfit'],
                'status' => $benefit['status'],
            ]);
        }

        // ✅ Delete old requirements and insert new ones
        $event->event_requirments()->delete();
        foreach ($request->requirment as $requirement) {
            $event->event_requirments()->create([
                'requirment' => $requirement['requirment'],
                'status' => $requirement['status'],
            ]);
        }

        DB::commit();

        return response()->json([
            'message' => 'Event updated successfully',
            'data' => $event->load(['event_benfits', 'event_requirments']),
        ], 200);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'message' => 'Failed to update event',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function deleteEvent($eventId)
    {
        DB::beginTransaction();

        try {
            $event = Event::find($eventId);

            if (!$event) {
                return response()->json(['message' => 'Event not found'], 404);
            }

            $event->event_benfits()->delete();
            $event->event_requirments()->delete();
            $event->delete();

            DB::commit();

            return response()->json(['message' => 'Event deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to delete event',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
