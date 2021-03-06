<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model
{

    use Sortable;
    public $sortable = ['id','created_at','price','paid'];

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'price', 'paid', 'table_id'
    ];


    // Get all items of this order.
    public function products() {
        return $this->belongsToMany('App\Product'); 
    }

    // Get the restaurant which offers this product.
    public function user() {
        return $this->belongsTo('App\User'); 
    }

    // Get the restaurant which offers this product.
    public function table() {
        return $this->belongsTo('App\Table'); 
    }

}
