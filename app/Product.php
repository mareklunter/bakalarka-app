<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use SoftDeletes;
    use Sortable;

    public $sortable = ['name','price'];

    /**
    * The attributes that are mass assignable.
    */
    protected $fillable = [
        'price', 'name', 'product_category_id', 'description'
    ];

    // Get the restaurant where this order was made.
    public function user() {
        return $this->belongsTo('App\User');
    }

     // Get category of this product.
     public function productCategory() {
        return $this->belongsTo('App\ProductCategory');
    }
}
