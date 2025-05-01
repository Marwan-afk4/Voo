<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaper extends Model
{


    protected $fillable =[
        'orgnization_id',
        'user_id',
        'front_identity',
        'back_identity',
        'selfi_image',
        'orgnization_paper',
        'status'
    ];

    public function orgnization(){
        return $this->belongsTo(User::class, 'orgnization_id');
    }

    public function getFrontLinkAttribute(){
        if(isset($this->attributes['front_identity'])){
            return asset('storage/'.$this->attributes['front_identity']);
        }
        return null;
    }

    public function getBackLinkAttribute(){
        if(isset($this->attributes['back_identity'])){
            return asset('storage/'.$this->attributes['back_identity']);
        }
        return null;
    }

    public function getSelfiLinkAttribute(){
        if(isset($this->attributes['selfi_image'])){
            return asset('storage/'.$this->attributes['selfi_image']);
        }
        return null;
    }

    public function getOrgnizationLinkAttribute(){
        if(isset($this->attributes['orgnization_paper'])){
            return asset('storage/'.$this->attributes['orgnization_paper']);
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
