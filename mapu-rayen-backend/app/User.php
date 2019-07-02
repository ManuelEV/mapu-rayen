<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable{
    use Notifiable;

    //TODO verificar si el usuario esta bien, tengo dudas si slug y remeber_token es fillable
    protected $fillable = ['name', 'last_name','email','email_verified_at', 'password','slug','remember_token'];

    protected $hidden = ['password', 'remember_token',];

    public function resources(){
        return $this->hasMany('App\Resource');
    }

    public function enterprise(){
        return $this->belongsTo('App\Enterprise');
    }

    public function items(){
        return $this->hasMany('App\Item');
    }

    public function rol(){
        return $this->belongsTo('App\Role');
    }
}
