@extends('layouts.app')


@section('content')

    <h1>Objednávky</h1>

    <div class="table-responsive">

        <table class="table table-striped table-sm table-bordered" id="orderList">
            <thead>
                <tr class="bg-dark text-white">
                    <th scope="col">@sortablelink('id', 'Id')</th>
                    <th scope="col">@sortablelink('created_at', 'Vytvorené')</th>
                    <th scope="col">Obsahuje produktov</th>
                    <th scope="col">@sortablelink('price', 'Cena')</th>
                    <th scope="col">@sortablelink('paid', 'Stav')</th>
                    <th scope="col"><i class="fas fa-info"></i></th>
                </tr>
            </thead>
    
            <tbody>
                @if ($orders->isEmpty())
                    <tr>
                        <td colspan="6">
                            Zatiaľ neboli vykonané žiadne objednávky.
                        </td>
                    </tr>
                @endif
    
                @foreach ($orders as $order)
                    <tr>
                        <th scope="row"> <a class="btn btn-sm btn-link orderDetails" href="#">{{ $order->id }}</a> </th>
                        <td> {{ date_format($order->created_at, 'd.m.Y | H:i') }} </td>
                        <td> {{ count($order->products()->withTrashed()->get()) }} </td> {{-- include soft deleted items --}}
                        <td> {{ $order->price }}€</td>
                        <td>
                            @if ($order->paid)
                                <span class="badge badge-success">Zaplatené</span>
                            @else
                                <span class="badge badge-danger">Nezaplatené</span>
                            @endif
                        </td>
    
                        <td class="actions-3">
                            @if (!$order->paid)
                                <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary btn-sm"><i
                                        class="far fa-edit"></i></a>
                            @else
                                <fieldset class="btn btn-secondary btn-sm" disabled><i class="far fa-edit"></i></fieldset>
                            @endif
    
                            <a href="{{ route('orders.pay', $order) }}" class="btn btn-info btn-sm"><i
                                    class="fas fa-money-check-alt"></i></a>
    
    
                            @if (!$order->paid)
                                <form action="{{ route('orders.destroy', $order) }}"
                                    onsubmit="return confirm('Are you sure?');" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                            class="fas fa-trash-alt"></i></button>
                                </form>
                            @else
                                <fieldset class="btn btn-secondary btn-sm" disabled><i class="fas fa-trash-alt"></i></fieldset>
                            @endif
    
                        </td>
                    </tr>
    
                    <tr class="orderDetailsDiv">
                        <td colspan="12">
                            @if ($order->table)
                                <strong><p>{{ $order->table->tag }}</p></strong>
                            @else
                                <p>Žiaden stôl</p>
                            @endif
    
                            @foreach ($order->products()->withTrashed()->get() as $product)
                                <p>{{ $product->name }}: {{ $product->price }}€</p>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table> 
    </div>

    <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-between" id="periodButtons">
        {{-- Time period buttons --}}
        <div class="btn-group">
            <a href="{{ route('orders.index') }}"
                class="btn btn-outline-primary timePeriodBtn {{ request()->is('orders') ? 'active' : '' }}">Dnes</a>
            <a href="{{ route('orders.index', 'week') }}"
                class="btn btn-outline-primary timePeriodBtn {{ request()->is('orders/week') ? 'active' : '' }}">Týždeň</a>
            <a href="{{ route('orders.index', 'month') }}"
                class="btn btn-outline-primary timePeriodBtn {{ request()->is('orders/month') ? 'active' : '' }}">Mesiac</a>
            <a href="{{ route('orders.index', 'all') }}"
                class="btn btn-outline-primary timePeriodBtn {{ request()->is('orders/all') ? 'active' : '' }}">Celé obdobie</a>
        </div>

        {{-- Paginations-kyslik --}}
        <div class="mt-3 mt-md-0">
            {!! $orders->appends(\Request::except('page'))->render() !!}
        </div>
    </div>

    <a href="{{ route('orders.create') }}" class="btn btn-info mt-3">Nová objednávka</a>
@endsection
