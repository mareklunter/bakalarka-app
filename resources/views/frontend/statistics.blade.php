@extends('layouts.master')


@section('content')
    
    <h1>Štatistiky</h1>
    
    <div class="col-10">
        {!! $chart->container() !!}
    </div>
    
    
    {!! $chart->script() !!}
@endsection