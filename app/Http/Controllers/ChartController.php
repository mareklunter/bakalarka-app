<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function ordersChartUpdate(string $timePeriod = 'week') {
        switch ($timePeriod) {
            case 'week':
                $limit = 7;
                break;
            case 'month':
                $limit = 30;
                break;
            case 'sixMonths':
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

        //create dailyOrders array where: keys->dates & values->daily sales/orders 
        $dailyOrders = [];
        foreach ($datesOpened as $key => $value) {
            $dailyOrders[$value] = auth()->user()->orders()->where('created_at', 'like' , $value.'%')->count();
        }

        $labels = array_keys($dailyOrders);
        $data = array_values($dailyOrders);

        return response()->json(compact('labels', 'data'));
    }

    

    public function salesChartUpdate(string $timePeriod = 'week') {
        switch ($timePeriod) {
            case 'week':
                $limit = 7;
                break;
            case 'month':
                $limit = 30;
                break;
            case 'sixMonths':
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

        //create dailySales array where: keys->dates & values->daily sales/orders 
        $dailySales = [];
        foreach ($datesOpened as $key => $value) {
            $dailySales[$value] = auth()->user()->orders()->where('created_at', 'like' , $value.'%')->sum('price');
        }

        $labels = array_keys($dailySales);
        $data = array_values($dailySales);

        return response()->json(compact('labels', 'data'));
    }
}
