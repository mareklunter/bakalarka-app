<?php

namespace App\Http\Controllers;

use App\Shift;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($week = 'current', $action = 'none')
    {
        switch ($action) {
            case 'none':
                $startWeek = Carbon::now()->startOfWeek();
                $endWeek = Carbon::now()->endOfWeek();
                break;
            case 'next':
                $startWeek = Carbon::parse($week)->addWeek();
                $endWeek = Carbon::parse($week)->addWeek(2);
                break;
            case 'previous':
                $startWeek = Carbon::parse($week)->subWeek();
                $endWeek = Carbon::parse($week);
                break;
        }

        $employees = auth()->user()->employees;

        //delete old shifts(before current week)
        foreach ($employees as $employee) {
            foreach ($employee->shifts as $shift) {
                if ($shift->endDate < $startWeek) {
                    $this->destroy($shift);
                }
            }
        }

        $dateInterval = \DateInterval::createFromDateString('1 day');
        //init Date Period from start date to end date
        $week = new \DatePeriod($startWeek, $dateInterval, $endWeek);

        return view('shifts.index', compact('employees', 'startWeek', 'endWeek', 'week'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check if shifts crosses

        $this->validate($request, [
            'employee_id'   => 'required',
            'startDate'     => 'required',
            'endDate'       => 'required',
        ]);

        $newShift = new Shift([
            'startDate'     => $request->startDate,
            'endDate'       => $request->endDate,
            'description'   => $request->description,
        ]);

        $employee = Employee::find($request->employee_id);

        //check employee shifts crossing
        foreach ($employee->shifts as $oldShift) {
            if (($newShift->startDate >= $oldShift->startDate && $newShift->startDate <= $oldShift->endDate) || ($newShift->endDate >= $oldShift->startDate && $newShift->endDate <= $oldShift->endDate)) {
                //pozri laravel error handling a vypis chybu na view <<<<<<<<<<<<<<<<<<<<<<<<<<<<,,
                return redirect(route('shifts.index'));
            }
        }

        //store new shift
        $employee->shifts()->save($newShift);

        return redirect(route('shifts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        $shift->delete();

        return back();
    }
}
