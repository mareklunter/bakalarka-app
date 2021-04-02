@extends('layouts.master')


@section('content') 
    
    <a href="" class="btn btn-dark float-right">Režim kuchyne</a>
    <h1>Objednávky</h1>

   

    <table class="table table-striped table-sm border-bottom">
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
            @if ( $orders->isEmpty() )
            <tr>
              <td colspan="6">
                Zatiaľ neboli vykonané žiadne objednávky.
              </td>
            </tr>
            @endif

            @foreach ($orders as $order) 
                <tr>
                    <th scope="row"> {{ $order->id }} </th>
                    <td> {{ date_format($order->created_at, 'd.m.Y | H:i') }} </td>
                    <td> {{ count($order->products()->withTrashed()->get()) }} </td> {{-- include soft deleted items --}}
                    <td> {{ $order->price }}€</td>
                    <td>
                        @if ( $order->paid )
                            <span class="badge badge-success">Zaplatené</span>
                        @else
                            <span class="badge badge-danger">Nezaplatené</span>
                        @endif
                    </td>

                    <td class="actions-3"> 
                      @if ( ! $order->paid )
                        <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                      @else
                        <fieldset class="btn btn-secondary btn-sm" disabled><i class="far fa-edit"></i></fieldset>
                      @endif

                      <a href="{{ route('orders.pay', $order) }}" class="btn btn-info btn-sm"><i class="fas fa-money-check-alt"></i></a>


                      @if ( ! $order->paid )
                        <form action="{{ route('orders.destroy', $order) }}"  onsubmit="return confirm('Are you sure?');" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </form>
                      @else
                        <fieldset class="btn btn-secondary btn-sm" disabled><i class="fas fa-trash-alt"></i></fieldset>
                      @endif
                      
                    </td>
                </tr>
            @endforeach 
        </tbody>
      </table>

      <div class="d-flex justify-content-between">
        {{-- Time period buttons --}}
        <div class="btn-group">
          <a href="{{ route('orders.index') }}" class="btn btn-primary {{ (request()->is('orders')) ? 'active' : '' }}">Dnes</a>
          <a href="{{ route('orders.index', 'week') }}" class="btn btn-primary {{ (request()->is('orders/week')) ? 'active' : '' }}">Týždeň</a>
          <a href="{{ route('orders.index', 'month') }}" class="btn btn-primary {{ (request()->is('orders/month')) ? 'active' : '' }}">Mesiac</a>
          <a href="{{ route('orders.index', 'all') }}" class="btn btn-primary {{ (request()->is('orders/all')) ? 'active' : '' }}">Celé obdobie</a>
        </div>

        {{-- Paginations-kyslik --}}
        <div>
          {!! $orders->appends(\Request::except('page'))->render() !!}
        </div>
      </div>

      <a href="{{ route('orders.create') }}" class="btn btn-info">Nová objednávka</a>
@endsection