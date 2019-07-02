<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permissions_role extends Model
{


    public function rol(){
        return $this->belongsTo('App\Role');
    }

    public function permission_roles(){
        return $this->belongsTo('App\Permission');
    }
}
