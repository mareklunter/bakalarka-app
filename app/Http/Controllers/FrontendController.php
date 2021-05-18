<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class FrontendController extends Controller
{
    public function dashboard() {
        $oneHourLimit = Carbon::now()->subHour();
        $orderLimitCount = auth()->user()->orders()->where('created_at', '<' , $oneHourLimit)->count();
 
        $today = Carbon::today();
        $employees = auth()->user()->employees;
        $emplToday = 0;
        foreach ($employees as $index => $employee) {
            if(isset($employee->shifts)) {
                foreach ($employee->shifts as $shift) {
                    $startDate = Carbon::parse($shift->startDate);
                    $endDate = Carbon::parse($shift->endDate);
                    if($startDate <= $today && $endDate >= $today) {
                        $emplToday++;
                    };
                }
            };
        }
        
        $salesToday = auth()->user()->orders()->where('created_at', '>', $today)->sum('price');
        $ordersToday = auth()->user()->orders()->where('created_at', '>', $today)->count();

        return view('frontend.dashboard', [
            'orderLimitCount'   => $orderLimitCount,
            'emplToday'         => $emplToday,
            'salesToday'        => $salesToday,
            'ordersToday'       => $ordersToday
        ]);
    }

    public function statistics() {
        return view('frontend.statistics');
    }
}
