@extends('layouts.app')


@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="float-left">
        <a href="{{ route('orders.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <h2 class="mb-4">Nová objednávka</h2>

    <form id="orderForm" action="{{ route('orders.store') }}" method="POST">
        @csrf

        <div class="table-responsive">
            <table class="table table-sm table-bordered" id="orderTable">
                <thead>
                    <tr>
                        <th scope="col">Produkt</th>
                        <th scope="col">Cena</th>
                        <th scope="col">Počet</th>
                        <th scope="col">Spolu</th>
                        <th scope="col"><a href="#" class="btn btn-primary btn-block" id="addToOrder"><i
                                    class="fas fa-plus-circle fa-lg"></i></a></th>
                    </tr>
                </thead>
     
                <tbody>
                    <tr id="R0">
                        <td>
                            <select class="form-control product"  data-container="body" data-size="5" title="-- vyber produkt --" data-live-search="true" name="product[]">
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                        {{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
    
                        <td>
                            <div class="form-group">
                                <input type="number" step="0.01" min="0" class="form-control price" value="0" readonly>
                            </div>
                        </td>
    
                        <td>
                            <div class="form-group">
                                <input type="number" min="1" class="form-control amount" value="1" name="amount[]" disabled>
                            </div>
                        </td>
    
                        <td>
                            <div class="form-group">
                                <input type="number" step="0.01" min="0" class="form-control totalPrice" value="0" readonly>
                            </div>
                        </td>
    
                        <td>
                            <div class="form-group">
                                <a href="#" class="btn btn-danger btn-sm" id="delete_R0"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </td>
    
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="box box-big col-10 col-md-6 p-3 my-4 row justify-content-center">
            <h3>Vyber stôl</h3>
            <select class="form-control" title="-- vyber stôl --" data-live-search="true" name="table_id" id="table_id" data-size="5">
                @foreach ($tables as $table)
                    <option value="{{ $table->id }}">{{ $table->tag }} </option>
                @endforeach
            </select>
        </div>

        <h3>Zaplatiť spolu: <span class="priceTag text-danger">0</span>€</h3>
        <input type="number" step="0.01" min="0" name="orderPrice" id="orderPrice" hidden>
        <button type="submit" class="btn btn-primary">Potvrdiť</button>
    </form>

    {{-- restaurant products -> for JS - filling new select --}}
    <select id="productOpt" hidden disabled>
        @foreach ($products as $product)
            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
        @endforeach
    </select>

@endsection
