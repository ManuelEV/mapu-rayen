<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item_log extends Model
{

    protected $fillable = [
        'item_id'
    ];

    public function item()
    {
        return $this->belongsToMany('App\Item');
    }
}
