<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function __construct()
    {
        // check if user is logged in when any method is called - if no, redirect to login
        $this->middleware('auth');
    }

    public function dashboard() {
        return view('frontend.dashboard');
    }

    public function map() {
        return view('frontend.map');
    }

    public function sales() {
        return view('frontend.sales');
    }


    public function new_order() {
        return view('frontend.new_order');
    }
}
