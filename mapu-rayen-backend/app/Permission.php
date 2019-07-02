<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name','description'];

    public function permission_roles(){
        return $this->hasMany('App\Permission_role');
    }
}
