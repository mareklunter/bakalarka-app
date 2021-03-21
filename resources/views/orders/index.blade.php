@extends('layouts.master')


@section('content')
    
    <a href="" class="btn btn-dark float-right">Režim kuchyne</a>
    <h1>order page</h1>
    <table class="table table-striped table-sm border-bottom">
        <thead>
          <tr class="bg-dark text-white">
            <th scope="col">ID</th>
            <th scope="col">Vytvorená</th>
            <th scope="col">Obsahuje produktov</th>
            <th scope="col">Zaplatiť</th>
            <th scope="col">Stav <a href="{{route('orders.sortStatus')}}"><i class="fas fa-sort"></i></a></th>
            <th scope="col"><i class="fas fa-info"></i></th>
        </tr>
        </thead> 
        
        <tbody>
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

      <div class="d-flex justify-content-end">
        {{ $orders->links() }}
      </div>

      <a href="{{ route('orders.create') }}" class="btn btn-info">Nová objednávka</a>
@endsection