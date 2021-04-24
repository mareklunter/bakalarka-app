<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'tag', 'seats', 'type', 'occupied',
    ];

    // Get the restaurant to which table belongs.
    public function user() {
        return $this->belongsTo('App\User'); 
    }

    // Get the restaurant to which table belongs.
    public function orders() {
        return $this->hasMany('App\Order'); 
    }
}
