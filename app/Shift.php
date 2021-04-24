<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{

    public $timestamps = false;

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'employee_id', 'startDate', 'endDate', 'description',
    ];

    public function employee() {
        return $this->belongsTo('App\Employee');
    }
}
