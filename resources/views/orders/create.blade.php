@extends('layouts.master')


@section('content')

    <div class="text-left">
      <a href="{{route('orders.index')}}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf

      {{-- <div class="form-group">
          <label for="table">Stôl:</label>
          <select class="form-control" data-live-search="true" name="table" id="table">
            @foreach ($table as $table)
                <option value="">{{  }}</option>
              @endforeach
          </select>
        </div> --}}

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
            <tr class="d-flex" id="R0">
              <td class="col-4">

                  <select class="form-control product" data-live-search="true"  name="product[]">
                    <option disabled selected value> -- vyber produkt -- </option>
                    @foreach ($products as $product)
                      <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                    @endforeach
                  </select>
              </td>

              <td class="col-2">
                <div class="form-group">
                  <input type="float" class="form-control price" value="0" readonly>
                </div>
              </td>

              <td class="col-2">
                <div class="form-group">
                  <input type="number" min="1" step="1" class="form-control amount" value="1" name="amount[]" disabled> 
                </div>  
              </td>

              <td class="col-3">
                <div class="form-group">
                  <input type="float" class="form-control totalPrice" value="0" readonly>
                </div>  
              </td>
              
              <td class="col-1">
                  <div class="form-group">
                      <a href="#" class="btn btn-danger btn-sm" id="delete_R0"><i class="fas fa-trash-alt"></i></a>
                  </div>  
              </td>
            </tr>
          </tbody>

        </table>

        <h4>Zaplatiť spolu: <span class="priceTag text-danger">0</span>€</h4>
        <input type="float" name="orderPrice" id="orderPrice" hidden>
        <button type="submit" class="btn btn-primary">Potvrdiť</button>

    </form>

    <select id="selOptions" hidden disabled>
      <option disabled selected value> -- vyber produkt -- </option>
      
      @foreach ($products as $product)
          <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
      @endforeach
    </select>

@endsection