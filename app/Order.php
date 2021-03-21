<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'price', 'paid'
    ];


    // Get all items of this order.
    public function products() {
        return $this->belongsToMany('App\Product'); 
    }

    // Get the restaurant which offers this product.
    public function user() {
        return $this->belongsTo('App\User'); 
    }

}
