<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['enterprise_id','name','description'];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function permission_roles(){
        return $this->hasMany('App\Permissions_role');
    }
}
