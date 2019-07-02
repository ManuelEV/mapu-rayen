<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name','type','isnull','start','date','finish','cost','percentComplete','percentWorkComplete'];

    public function assignments(){
        return $this->hasMany('App\Assignment');
    }

    public function project(){
        return $this->belongsTo('App\Project');
    }
}
