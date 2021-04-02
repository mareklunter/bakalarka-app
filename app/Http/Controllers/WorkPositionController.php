<?php

namespace App\Http\Controllers;

use App\WorkPosition;
use App\User;
use Illuminate\Http\Request;

class WorkPositionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workPositions = auth()->user()->workPositions()->paginate(10);

        return view('workPositions.index', [
            'workPositions' => $workPositions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'positionName'  => 'required',
        ]);

        $request->user()->workPositions()->create([
            'positionName'  => $request->positionName
        ]);

        return redirect(route('workPositions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WorkPosition  $workPosition
     * @return \Illuminate\Http\Response
     */
    public function show(WorkPosition $workPosition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\WorkPosition  $workPosition
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkPosition $workPosition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WorkPosition  $workPosition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkPosition $workPosition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkPosition $workPosition)
    {
        $workPosition->delete();
        return back();
    }
}
