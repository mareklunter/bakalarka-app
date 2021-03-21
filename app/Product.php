<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'price', 'name', 'product_category_id', 'description'
    ];

    // Get the order(s) which contains this item.
    // public function order() {
    //    return $this->belongsToMany('App\Order'); // |TODO je toto potrebne??
    // }

    // Get the restaurant where this order was made.
    public function user() {
        return $this->belongsTo('App\User');
    }

     // Get category of this product.
     public function productCategory() {
        return $this->belongsTo('App\ProductCategory');
    }
}
