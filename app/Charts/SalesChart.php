<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class SalesChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        //get all dates when orders occurred and group by dates
        $datesOpened = auth()->user()->orders()->orderBy('created_at')->pluck('created_at')->toArray();
        $datesOpened = array_reverse($datesOpened);
        foreach($datesOpened as $key => $value) {
            $datesOpened[$key] = $value->toDateString();
        }
        $datesOpened = array_unique($datesOpened, SORT_STRING);
        
        //get required time period - default 7 days
        $datesOpened = array_slice($datesOpened, 0, 7); 

        //create dailySales array where: keys->dates & values->daily sales/orders 
        $dailySales = [];
        foreach ($datesOpened as $key => $value) {
            $dailySales[$value] = auth()->user()->orders()->where('created_at', 'like' , $value.'%')->sum('price');
        }

        $labels = array_keys($dailySales);
        $data = array_values($dailySales);

        return Chartisan::build()
            ->labels($labels)
            ->dataset('Tržby(€)', $data);
    }
}