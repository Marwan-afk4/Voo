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
        'account_status'
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
}
