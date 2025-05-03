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
        'location',
        'task_hours',
        'google_map_location',
        'apply'
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

    public function task_requirments()
    {
        return $this->hasMany(TaskRequirment::class);
    }

    public function task_benfits()
    {
        return $this->hasMany(TaskBenfit::class);
    }

    public function task_volunteers()
    {
        return $this->hasMany(TaskVolunteer::class);
    }

    public function my_task_volunteers()
    {
        return $this->hasMany(TaskVolunteer::class)
        ->where('user_id', auth()->user()->id);
    }

    public function suggests()
    {
        return $this->hasMany(Suggest::class);
    }

    public function shakwas()
    {
        return $this->hasMany(Shakwa::class);
    }
}
