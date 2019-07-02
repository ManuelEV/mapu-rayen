<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = ['name','description'];

    public function enterprise(){
        return $this->belongsTo('App\Enterpise');
    }

    public function account_type(){
        return $this->belongsTo('App\Account_type');
    }

    public function minor_book(){
        return $this->belongsTo('App\Minor_book');
    }

    public function object(){
        return $this->belongsTo('App\Object');
    }
}
