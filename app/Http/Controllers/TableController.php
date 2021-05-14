<?php

namespace App\Http\Controllers;

use App\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = auth()->user()->tables;
        
        return view('tables.index', compact('tables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tag'   => 'required|unique:tables|max:20',
            'seats' => 'required',
            'type'  => 'required'
        ]);

        $request->user()->tables()->create([
            'tag'   => $request->tag,
            'seats' => $request->seats,
            'type'  => $request->type
        ]);

        return redirect(route('tables.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Table  $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return back();
    }
}
