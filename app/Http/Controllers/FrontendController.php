<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class FrontendController extends Controller
{
    public function dashboard() {
        $oneHourLimit = Carbon::now()->subHour();
        $orderLimitCount = auth()->user()->orders->where('created_at', '<' , $oneHourLimit)->count();
 
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
        // dd(auth()->user()->tables->where('occupied', '=', 'false')->count());
        $freeTables = auth()->user()->tables->where('occupied', '=', 'false')->count();
        $ordersToday = auth()->user()->orders->where('created_at', '>', $today)->count();
        $salesToday = auth()->user()->orders->where('created_at', '>', $today)->sum('price');
        $salesYesterday = auth()->user()->orders->where('created_at', '>', Carbon::yesterday())->where('created_at', '<', $today)->sum('price');
        $salesWeek = auth()->user()->orders->where('created_at', '>', Carbon::now()->sub('7days'))->where('created_at', '<', Carbon::now())->sum('price');

        return view('frontend.dashboard', [
            'orderLimitCount'   => $orderLimitCount,
            'emplToday'         => $emplToday,
            'ordersToday'       => $ordersToday,
            'freeTables'        => $freeTables,
            'salesToday'        => $salesToday,
            'salesYesterday'    => $salesYesterday,
            'salesWeek'         => $salesWeek
        ]);
    }

    public function statistics() {
        return view('frontend.statistics');
    }
}
