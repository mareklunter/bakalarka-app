<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{

    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'categoryName'
    ];

    // Get the restaurant where this order was made.
    public function user() {
        return $this->belongsTo('App\User');
    }

    // Get all products of this category.
    public function products() {
        return $this->hasMany('App\Product');
    }
}
