<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'employee_id', 'startDate', 'endDate', 'description',
    ];
}
