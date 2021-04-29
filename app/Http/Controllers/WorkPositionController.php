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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'positionName'  => 'required|max:20',
        ]);

        $request->user()->workPositions()->create([
            'positionName'  => $request->positionName
        ]);

        return redirect(route('workPositions.index'));
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
