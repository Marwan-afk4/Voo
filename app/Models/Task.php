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
        'image',
        'orgnization_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'image_link',
    ];

    public function getImageLinkAttribute(){
        if(isset($this->attributes['image'])){
            return asset('storage/'.$this->attributes['image']);
        }
        return null;
    }

    public function from_zone()
    {
        return $this->belongsTo(Zone::class,'from_zone_id');
    }

    public function to_zone()
    {
        return $this->belongsTo(Zone::class,'to_zone_id');
    }

    public function orgnization()
    {
        return $this->belongsTo(User::class,'orgnization_id');
    }
}
