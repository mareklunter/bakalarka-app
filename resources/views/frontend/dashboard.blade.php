@extends('layouts.master')


@section('content')

    <h1>Dashboard</h1>

    @if ($orderLimitCount > 0) 
        <div id="alerts-wrapper">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Počet objednávok, ktoré neboli zaplatené dlhšie než hodinu: <strong>{{$orderLimitCount}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif
    <p>testin</p>
 
@endsection