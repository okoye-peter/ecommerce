<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderQueue extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsToMany(Product::class);
    }
}

