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

    <div class="text-left mb-4">
        <a href="{{ route('orders.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <form id="orderForm" action="{{ route('orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="table-responsive">
            <table class="table table-sm table-bordered" id="orderTable">
                <thead>
                    <tr>
                        <th scope="col">Produkt</th>
                        <th scope="col">Cena</th>
                        <th scope="col">Počet</th>
                        <th scope="col">Spolu</th>
                        <th><a href="#" class="btn btn-primary btn-block" id="addToOrder"><i
                                    class="fas fa-plus-circle fa-lg"></i></a></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($order_items as $product_id => $amount)
                        <tr id="R{{ $index }}">
                            <td>
                                <select class="form-control product" data-container="body" data-size="5" title="-- vyber produkt --" data-live-search="true" name="product[]">
                                    @foreach ($products as $product)
                                        @if ($product->id == $product_id)
                                        {{-- options are not-trashed products except for already ordered item which was trashed --}}
                                            @if ($product->trashed())
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                    disabled selected>{{ $product->name }}</option>
                                            @else
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                                    selected>{{ $product->name }}</option>
                                            @endif

                                        @elseif ( ! $product->trashed() )
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                {{ $product->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <div class="form-group">
                                    <input type="number" step="0.01" min="0" class="form-control price"
                                        value="{{ $order->products()->withTrashed()->get()->find($product_id)->price }}"
                                        readonly>
                                </div>
                            </td>

                            <td>
                                <div class="form-group">
                                    <input type="number" step="1" min="1" class="form-control amount"
                                        value="{{ $amount }}" name="amount[]" required>
                                </div>
                            </td>

                            <td>
                                <div class="form-group">
                                    <input type="number" step="0.01" min="0" class="form-control totalPrice"
                                        value="{{ $order->products()->withTrashed()->get()->find($product_id)->price * $amount }}"
                                        readonly>
                                </div>
                            </td>

                            <td>
                                <div class="form-group">
                                    <a href="#" class="btn btn-danger btn-sm" id="delete_R{{ $index++ }}"><i
                                            class="fas fa-trash-alt"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="box box-big col-10 col-md-6 p-3 my-4 row justify-content-center">
            <h3>Vyber stôl</h3>

            <select class="form-control" title="-- vyber stôl --" data-size="5" data-live-search="true" id="table_id" name="table_id">
                {{-- check if order->table is null  --}}
                @if ($order->table)
                    @foreach ($tables as $table)
                        @if ($order->table->id == $table->id)
                            <option value="{{ $table->id }}" selected>{{ $table->tag }}</option>
                        @else
                            <option value="{{ $table->id }}">{{ $table->tag }}</option>
                        @endif
                    @endforeach
                @else
                    @foreach ($tables as $table)
                        <option value="{{ $table->id }}">{{ $table->tag }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <h4>Zaplatiť spolu: <span class="priceTag text-danger">{{ $order->price }}</span>€</h4>
        <input type="number" step="0.01" min="0" name="orderPrice" id="orderPrice" hidden>
        <button type="submit" class="btn btn-primary">Potvrdiť</button>
    </form>

    {{-- restaurant products -> for JS - filling new select --}}
    <select id="productOpt" hidden disabled>
        @foreach ($products as $product)
            @if (!$product->trashed())
                <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
            @endif
        @endforeach
    </select>

@endsection
