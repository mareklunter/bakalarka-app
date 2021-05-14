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
        $user_id = $request->user()->id;
        $this->validate($request, [
            'positionName'  => "required|max:20|unique:work_positions,positionName,NULL,id,deleted_at,NULL,user_id,$user_id",
        ]);

        $is_trashed = $request->user()->workPositions()->onlyTrashed()->get()->where('positionName', '=', $request->positionName)->first();

        if ($is_trashed) {

            $is_trashed->deleted_at = null;
            $is_trashed->save();

        } else {

            $request->user()->workPositions()->create([
                'positionName'  => $request->positionName
            ]);
        }

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
