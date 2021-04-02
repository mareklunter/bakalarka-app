@extends('layouts.master')


@section('content')
    
    <h1>Štatistiky</h1>
    
    <div class="row justify-content-center">
        <div class="chart-box col-11 col-lg-6">
            <div id="chart" style="height: 300px;"></div>

            <div class="btn-group">
                <a href="{{ route('statistics') }}" class="btn btn-warning {{ (request()->is('statistics')) ? 'active' : '' }}">7 dní</a>
                <a href="{{ route('statistics', 'month') }}" class="btn btn-warning {{ (request()->is('statistics/month')) ? 'active' : '' }}">30 dní</a>
                <a href="{{ route('statistics', 'six-months') }}" class="btn btn-warning {{ (request()->is('statistics/six-months')) ? 'active' : '' }}">90 dní</a>
                <a href="{{ route('statistics', 'all') }}" class="btn btn-warning {{ (request()->is('statistics/all')) ? 'active' : '' }}">Celé obdobie</a>
            </div>
        </div>
        
        <div class="chart-box col-11 col-lg-6">
            <div id="chart" style="height: 300px;"></div>

            <div class="btn-group">
                <a href="{{ route('statistics') }}" class="btn btn-success {{ (request()->is('statistics')) ? 'active' : '' }}">7 dní</a>
                <a href="{{ route('statistics', 'month') }}" class="btn btn-success {{ (request()->is('statistics/month')) ? 'active' : '' }}">30 dní</a>
                <a href="{{ route('statistics', 'six-months') }}" class="btn btn-success {{ (request()->is('statistics/six-months')) ? 'active' : '' }}">90 dní</a>
                <a href="{{ route('statistics', 'all') }}" class="btn btn-success {{ (request()->is('statistics/all')) ? 'active' : '' }}">Celé obdobie</a>
            </div>
        </div>
    </div>
    
@endsection