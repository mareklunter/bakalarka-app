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

    <h2>Dnes</h2>
    <div class="row justify-content-around">
        <div class="box dashboard-box box-dark col-10 col-md-7 col-lg-3">
            <span class="info-row big">4</span>
            Pracuje zamestnancov
        </div>
    
        <div class="box dashboard-box box-red col-10 col-md-7 col-lg-3">
            <span class="info-row big">5</span>
            Počet objednávok
        </div>
    
        <div class="box dashboard-box box-yellow col-10 col-md-7 col-lg-3">
            <span class="info-row big">546.98€</span>
            Tržby
        </div>
    </div>
 
@endsection