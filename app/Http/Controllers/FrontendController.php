<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class FrontendController extends Controller
{
    public function dashboard() {
        $oneHourLimit = Carbon::now()->subHour();
        $orderLimitCount = auth()->user()->orders()->where('created_at', '<' , $oneHourLimit)->count();

        return view('frontend.dashboard', [
            'orderLimitCount' => $orderLimitCount
        ]);
    }

    public function statistics() {
        return view('frontend.statistics');
    }
}
