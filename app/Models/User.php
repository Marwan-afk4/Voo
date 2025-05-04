<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens;

    protected $fillable =[
        'country_id',
        'city_id',
        'name',
        'email',
        'password',
        'phone',
        'birth',
        'gender',
        'total_hours',
        'total_events',
        'avatar_image',
        'orgnization',
        'is_email_verified',
        'email_verification_code',
        'account_status',
        'role',
        'orgnization_id',
        'total_tasks'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'avatar_image_link'
    ];


    public function getAvatarImageLinkAttribute(){
        if(isset($this->attributes['avatar_image'])){
            return asset('storage/'.$this->attributes['avatar_image']);
        }
        return null;
    }


    // public function events()
    // {
    //     return $this->belongsToMany(Event::class);
    // }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function event_volunteers()
    {
        return $this->hasMany(EventVolunteer::class);
    }

    public function user_papers()
    {
        return $this->hasMany(UserPaper::class);
    }

    public function orgnization()
    {
        return $this->belongsTo(User::class,'orgnization_id');
    }

    public function events()
    {
        return $this->belongsTo(Event::class,'orgnization_id');
    }

    public function tasks()
    {
        return $this->belongsTo(Task::class,'orgnization_id');
    }

    public function user_events()
    {
        return $this->belongsToMany(Event::class,'event_volunteers');
    }

    public function user_tasks()
    {
        return $this->belongsToMany(Task::class,'task_volunteers');
    }
}
