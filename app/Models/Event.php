<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{


    protected $fillable =[
        'country_id',
        'city_id',
        'zone_id',
        'name',
        'date',
        'start_time',
        'end_time',
        'number_of_volunteers',
        'available_volunteers',
        'location',
        'google_maps_location',
        'description',
        'image',
        'status'
    ];

    public function getImageLinkAttribute(){
        if(isset($this->attributes['image'])){
            return asset('storage/'.$this->attributes['image']);
        }
        return null;
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function event_benfits()
    {
        return $this->hasMany(EventBenfit::class);
    }

    public function event_requirments()
    {
        return $this->hasMany(EventRequirment::class);
    }

    public function event_volunteers()
    {
        return $this->hasMany(EventVolunteer::class);
    }

    public function vooHours()
    {
        return $this->hasMany(VooHour::class);
    }
}
