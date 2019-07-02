<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $casts = [
        'product_list' => 'array'
    ];
}
