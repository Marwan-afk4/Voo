<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{


    protected $fillable =[
        'name',
        'country_id',
        'city_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
