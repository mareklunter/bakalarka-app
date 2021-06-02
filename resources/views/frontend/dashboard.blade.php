@extends('layouts.app')


@section('content')

    <h1 class="page-header">Dashboard</h1>

    @if ($orderLimitCount > 0)
        <div id="alerts-wrapper" class="mb-4">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Počet objednávok, ktoré neboli zaplatené dlhšie než hodinu: <strong>{{ $orderLimitCount }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <div class="row justify-content-around">
        <div class="box dashboard-box box-dark col-5 col-lg-3">
            <span class="time-head">Dnes</span>
            <span class="info-row big">{{ $emplToday }}</span>
            Pracuje zamestnancov
        </div>

        <div class="box dashboard-box box-red col-5 col-lg-3 offset-lg-1">
            <span class="time-head">Dnes</span>
            <span class="info-row big">{{ $ordersToday }}</span>
            Počet objednávok
        </div>

        <div class="box dashboard-box box-purple col-5 col-lg-3 offset-lg-1">
            <span class="time-head">Teraz</span>
            <span class="info-row big">{{ $freeTables }}</span>
            Voľné stoly
        </div>

        <div class="box dashboard-box box-yellow col-5 col-lg-3">
            <span class="time-head">Dnes</span>
            <span class="info-row big">{{ $salesToday }}€</span>
            Tržby
        </div>

        <div class="box dashboard-box box-yellow1 col-5 col-lg-3 offset-lg-1">
            <span class="time-head">Včera</span>
            <span class="info-row big">{{ $salesYesterday }}€</span>
            Tržby
        </div>

        <div class="box dashboard-box box-yellow2 col-5 col-lg-3 offset-lg-1">
            <span class="time-head">Týždeň</span>
            <span class="info-row big">{{ $salesWeek }}€</span>
            Tržby
        </div>
 
    </div>

    <div id="color-calendar" class="mt-4"></div>
@endsection
