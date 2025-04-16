<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable =[
        'name',
        'flag'
    ];

    protected $appends = [
        'flag_link'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function getFlagLinkAttribute()
    {
        if(isset($this->attributes['flag'])){
            return asset('storage/'.$this->attributes['flag']);
        }
        return null;
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
