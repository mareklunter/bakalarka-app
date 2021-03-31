<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FrontendController extends Controller
{
    public function __construct()
    {
        // check if user is logged in when any method is called - if no, redirect to login
        $this->middleware('auth');
    }

    public function dashboard() {
        $oneHourLimit = Carbon::now()->subHour();
        $orderLimitCount = auth()->user()->orders()->where('created_at', '<' , $oneHourLimit)->count();

        return view('frontend.dashboard', [
            'orderLimitCount' => $orderLimitCount
        ]);
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