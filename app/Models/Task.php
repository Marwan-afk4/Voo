<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{


    protected $fillable =[
        'name',
        'from_zone_id',
        'to_zone_id',
        'date',
        'start_time',
        'number_of_voo_needed',
        'description',
        'status',
        'image'
    ];

    public function from_zone()
    {
        return $this->belongsTo(Zone::class,'from_zone_id');
    }

    public function to_zone()
    {
        return $this->belongsTo(Zone::class,'to_zone_id');
    }
}
