<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // Get all employees of this restaurant.
    public function employees() {
        return $this->hasMany('App\Employee');
    }

    // Get all orders of this restaurant.
    public function orders() {
        return $this->hasMany('App\Order');
    }

    // Get all products of this restaurant.
    public function products() {
        return $this->hasMany('App\Product');
    }

    // Get all work positions of this restaurant.
    public function workPositions() {
        return $this->hasMany('App\WorkPosition');
    }

    // Get all product caterogies of this restaurant.
    public function productCategories() {
        return $this->hasMany('App\ProductCategory');
    }
}
