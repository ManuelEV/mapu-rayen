<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $fillable=[
        'id','name','value','stock'
    ];

    public function sales(){
        return $this->belongsToMany(Sale::class, 'item_sale');
    }

}
