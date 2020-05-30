<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $guarded = [];

    protected function orderQueue(){
        return $this->hasMany(OrderQueue::class);
    }
}
