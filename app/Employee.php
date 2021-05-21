<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Employee extends Model
{

    use Sortable;
    public $sortable = ['lastName','created_at'];

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'firstName', 'lastName', 'work_position_id', 'phone', 'employed_since'
    ];

    // Get the restaurant where this employee works.
    public function user() {
        return $this->belongsTo('App\User');
    }

    // Get the work category of this employee.
    public function workPosition() {
        return $this->belongsTo('App\WorkPosition');
    }

    // Get shifts of the employee.
    public function shifts() {
        return $this->hasMany('App\Shift');
    }

    
    public function haveShift($day) {
        $shift = $this->shifts()->whereDate('startDate', '<=', $day)->whereDate('endDate', '>=', $day)->first();
        if ( $shift ) {
            return $shift;
        }
        return false;
    }
}
