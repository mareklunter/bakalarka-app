@extends('layouts.app')

@section('content')

    <h1>Menu</h1>

    <div class="table-responsive">
        <table class="table table-striped table-sm table-bordered">
            <thead>
                <tr class="bg-dark text-white">
                    <th scope="col">@sortablelink('name', 'Názov')</th>
                    <th scope="col">@sortablelink('price', 'Cena')</th>
                    <th scope="col">Kategória</th>
                    <th scope="col"><i class="fas fa-info"></i></th>
                </tr>
            </thead>

            <tbody>
                @if ($products->isEmpty())
                    <tr>
                        <td colspan="4">
                            Zatiaľ neboli vytvorené žiadne produkty.
                        </td>
                    </tr>
                @endif

                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->productCategory()->withTrashed()->get()->first()->categoryName ?? 'žiadna' }}</td>

                        <td class="actions-2">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm"><i
                                    class="far fa-edit"></i></a>

                            <form action="{{ route('products.destroy', $product) }}"
                                onsubmit="return confirm('Are you sure?');" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i
                                        class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-between" id="periodButtons">
        <div class="btn-group">
            <a href="{{ route('products.create') }}" class="btn btn-primary">Nový produkt</a>
            <a href="{{ route('productCategories.index') }}" class="btn btn-info">Kategórie</a>
        </div>

        <div class="mt-3 mt-md-0">
            {!! $products->appends(\Request::except('page'))->render() !!}
        </div>
    </div>
@endsection
