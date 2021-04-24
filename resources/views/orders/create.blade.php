@extends('layouts.master')


@section('content')

    <div class="float-left mb-4">
        <a href="{{ route('orders.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <h2>Nová objednávka</h2>

    <form id="orderForm" action="{{ route('orders.store') }}" method="POST">
        @csrf

        <table class="table table-sm table-bordered" id="orderTable">
            <thead>
                <tr class="d-flex">
                    <th class="col-4" scope="col">Produkt</th>
                    <th class="col-2" scope="col">Cena</th>
                    <th class="col-2" scope="col">Počet</th>
                    <th class="col-3" scope="col">Spolu</th>
                    <th class="col-1"><a href="#" class="btn btn-primary btn-block" id="addToOrder"><i
                                class="fas fa-plus-circle fa-lg"></i></a></th>
                </tr>
            </thead>

            <tbody>
                <tr class="d-flex" id="R0">
                    <td class="col-4">
                        <select class="form-control product" data-live-search="true" name="product[]">
                            <option disabled selected> -- vyber produkt -- </option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }}</option>
                            @endforeach
                        </select>
                    </td>

                    <td class="col-2">
                        <div class="form-group">
                            <input type="number" step="0.01" min="0" class="form-control price" value="0" readonly>
                        </div>
                    </td>

                    <td class="col-2">
                        <div class="form-group">
                            <input type="number" min="1" class="form-control amount" value="1" name="amount[]" disabled>
                        </div>
                    </td>

                    <td class="col-3">
                        <div class="form-group">
                            <input type="number" step="0.01" min="0" class="form-control totalPrice" value="0" readonly>
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

        <div class="box box-big col-10 col-md-6 p-3 my-4 row justify-content-center">
            <h3>Vyber stôl</h3>

            <select class="form-control" data-live-search="true" name="table_id" id="table_id">
                <option disabled selected> -- vyber stôl -- </option>
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
        <option disabled selected> -- vyber produkt -- </option>

        @foreach ($products as $product)
            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
        @endforeach
    </select>

@endsection
