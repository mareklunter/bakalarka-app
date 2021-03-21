@extends('layouts.master')

@section('content')

    <div class="text-left">
      <a href="{{route('orders.index')}}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <form action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT') 
        
        <table class="table table-sm table-bordered" id="orderTable">

          <thead>
            <tr class="d-flex">
              <th class="col-4" scope="col">Produkt</th>
              <th class="col-2" scope="col">Cena</th>
              <th class="col-2" scope="col">Počet</th>
              <th class="col-3" scope="col">Spolu</th>
              <th class="col-1"><a href="#" class="btn btn-primary btn-block" id="addToOrder"><i class="fas fa-plus-circle fa-lg"></i></a></th>
            </tr>
          </thead>

          <tbody>

            @foreach ($order_items as $product_id => $amount)
                <tr class="d-flex" id="R{{$index}}">
                  <td class="col-4">
                    <select class="form-control product" data-live-search="true" name="product[]">
                      <option disabled value> -- vyber produkt -- </option>
                      
                      @foreach ($products as $product)

                          @if ($product->id == $product_id)
                            {{-- options are not-trashed products except for already ordered item which was trashed  --}}
                            @if ( $product->trashed() )
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" disabled selected>{{ $product->name }}</option>
                            @else
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" selected>{{ $product->name }}</option>
                            @endif

                          @elseif ( ! $product->trashed() )
                              <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                          @endif

                      @endforeach

                    </select>
                  </td>
    
                  <td class="col-2">
                    <div class="form-group">
                      <input type="float" class="form-control price" value="{{$order->products()->withTrashed()->get()->find($product_id)->price}}" readonly>
                    </div>
                  </td>
    
                  <td class="col-2">
                    <div class="form-group">
                      <input type="number" min="1" step="1" class="form-control amount" value="{{$amount}}" name="amount[]">
                    </div>  
                  </td>
    
                  <td class="col-3">
                    <div class="form-group">
                      <input type="float" class="form-control totalPrice" value="{{$order->products()->withTrashed()->get()->find($product_id)->price * $amount}}" readonly>
                    </div>  
                  </td>
                   
                  <td class="col-1">
                    <div class="form-group">
                      <a href="" class="btn btn-danger btn-sm" id="delete_R{{$index++}}"><i class="fas fa-trash-alt"></i></a>
                    </div>  
                  </td>
                </tr>
            @endforeach

          </tbody>
        </table>

        <h4>Zaplatiť spolu: <span class="priceTag text-danger">{{$order->price}}</span>€</h4>
        <input type="float" name="orderPrice" id="orderPrice" hidden>

        <button type="submit" class="btn btn-primary">Potvrdiť</button>
  
    </form>

    {{-- select options for JS --}}
    <select id="selOptions" hidden disabled>
      <option disabled selected value> -- vyber produkt -- </option>
      
      @foreach ($products as $product)
          @if ( ! $product->trashed() )
              <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
          @endif
      @endforeach
    </select>
 
@endsection