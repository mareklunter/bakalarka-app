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

    {{-- ALL CATEGORIES --}}
    <div class="float-left">
        <a href="{{ route('products.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>
    <h1 class="page-header mb-4">Kategórie produktov</h1>

    <div class="row justify-content-around">
        <table class="table table-striped table-sm table-bordered col-11 col-md-7 order-md-last">
            <thead>
                <tr class="bg-dark text-white">
                    <th scope="col">Kategória</th>
                    <th scope="col"><i class="fas fa-info"></i></th>
                </tr>
            </thead>

            <tbody>
                @if ($productCategories->isEmpty())
                    <tr>
                        <td colspan="2">
                            Zatiaľ neboli vytvorené žiadne kategórie produktov.
                        </td>
                    </tr>
                @endif

                @foreach ($productCategories as $category)
                    <tr>
                        <td>{{ $category->categoryName }}</td>
                        <td>
                            <form action="{{ route('productCategories.destroy', $category) }}"
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

        {{-- ADD CATEGORY --}}
        <div class="box box-small col-11 col-md-4 order-md-first">
            <h3>Pridaj novú kategóriu</h3>
            <form action="{{ route('productCategories.store') }}" method="POST">
                @csrf
                <div class="input-group my-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Názov</span>
                    </div>
                    <input type="text" class="form-control" maxlength="20" name="name" id="name" required>
                </div>

                <button type="submit" class="btn btn-primary">Potvrdiť</button>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        {{ $productCategories->links() }}
    </div>

@endsection
