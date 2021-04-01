<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Charts\SalesChart;

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

    public function statistics() {

        $datesTest = auth()->user()->orders()->pluck('created_at');
        $formatted = [];
        foreach($datesTest as $key => $value) {
            $formatted[] = $value->toDateString();
        }
        $uniqueDates = array_unique($formatted, SORT_STRING);
        $novePole = [];

        foreach ($uniqueDates as $key => $value) {
            $novePole[$value] = auth()->user()->orders()->where('created_at', 'like' , $value.'%')->sum('price');
            var_dump($novePole[$value]);
        }

        // ->load($api)
        $chart = new SalesChart;
        $chart->labels(array_values($uniqueDates));
        $chart->dataset('My dataset', 'line', array_values($novePole));

        return view('frontend.statistics', compact('chart'));
    }


    public function new_order() {
        return view('frontend.new_order');
    }
}
