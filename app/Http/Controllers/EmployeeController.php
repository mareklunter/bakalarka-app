<?php

namespace App\Http\Controllers;

use App\Employee;
use App\WorkPosition;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\Rule\InvokedAtIndex;

class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = auth()->user()->employees()->sortable()->paginate(10);

        return view("employees.index", [
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $workPositions = auth()->user()->workPositions;

        return view("employees.create", [
            'workPositions' => $workPositions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstName'     => 'required|max:20',
            'lastName'      => 'required|max:20',
            'workPosition'  => 'required',
            'salary'        => 'required',
            'employedSince' => 'required',
        ]);

        $request->user()->employees()->create([
            'firstName'         => $request->firstName,
            'lastName'          => $request->lastName,
            'work_position_id'  => $request->workPosition,
            'salary'            => $request->salary,
            'employed_since'    => $request->employedSince
        ]);

        return redirect(route('employees.index'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $this->authorize('update', $employee);

        $workPositions = auth()->user()->workPositions()->withTrashed()->get();

        return view("employees.edit", [
            'employee'      => $employee,
            'workPositions' => $workPositions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $this->authorize('update', $employee);
       
        $this->validate($request, [
            'firstName'     => 'required|max:20',
            'lastName'      => 'required|max:20',
            'workPosition'  => 'required',
            'salary'        => 'required',
            'employedSince' => 'required',
        ]);

        $employee->firstName         = $request->firstName;
        $employee->lastName          = $request->lastName;
        $employee->work_position_id  = $request->workPosition;
        $employee->salary            = $request->salary;
        $employee->employed_since    = $request->employedSince;

        $employee->save();

        return redirect(route('employees.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return back();
    }
}
