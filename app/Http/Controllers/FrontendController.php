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

    public function statistics(string $timePeriod = 'week') {

        switch ($timePeriod) {
            case 'week':
                $limit = 7;
                break;
            case 'month':
                $limit = 30;
                break;
            case 'six-months':
                $limit = 90;
                break;
            case 'all':
                $limit = null;
                break;
        }

        //get all dates when orders occurred and group by dates
        $datesOpened = auth()->user()->orders()->orderBy('created_at')->pluck('created_at')->toArray();
        $datesOpened = array_reverse($datesOpened);
        foreach($datesOpened as $key => $value) {
            $datesOpened[$key] = $value->toDateString();
        }
        $datesOpened = array_unique($datesOpened, SORT_STRING);
        
        //get required time period
        if ( $limit ) {
            $datesOpened = array_slice($datesOpened, 0, $limit); 
        }

        //create dailySales and dailyOrders array where: keys->dates & values->daily sales/orders 
        $dailySales = [];
        $dailyOrders = [];
        foreach ($datesOpened as $key => $value) {
            $dailySales[$value] = auth()->user()->orders()->where('created_at', 'like' , $value.'%')->sum('price');
            $dailyOrders[$value] = auth()->user()->orders()->where('created_at', 'like' , $value.'%')->count();
        }

        //create charts
        $chart1 = new SalesChart;
        $chart1->labels(array_keys($dailySales));
        $chart1->dataset('Tržby(€)', 'line', array_values($dailySales))->color('#E09C0F')->backgroundColor('rgba(224, 156, 15, 0.2)');
        
        $chart2 = new SalesChart;
        $chart2->labels(array_keys($dailyOrders));
        $chart2->dataset('Počet objednávok', 'line', array_values($dailyOrders))->color('#3F871F')->backgroundColor('rgba(63, 135, 31, 0.2)');

        
        return view('frontend.statistics', compact('chart1','chart2'));
    }


    public function new_order() {
        return view('frontend.new_order');
    }
}
