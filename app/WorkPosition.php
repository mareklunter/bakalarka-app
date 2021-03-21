<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class WorkPosition extends Model
{
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'positionName'
    ];

    // Get the restaurant where this order was made.
    public function user() {
        return $this->belongsTo('App\User');
    }

     // Get all employees of this work position.
     public function employees() {
        return $this->hasMany('App\Employee');
    }
}
