@extends('layouts.master')


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
        <a href="{{ route('products.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <div class="box box-big col col-md-10 col-lg-8">
        <h2>Nový produkt</h2>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">Názov</span>
                </div>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">Cena</span>
                </div>
                <input type="number" step="0.01" min="0" class="form-control" name="price" id="price" required>
            </div>

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="category">Kategória</label>
                </div>

                <select class="form-control" data-live-search="true" id="category" name="category">
                    @foreach ($productCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">Popis</span>
                </div>
                <input type="text" class="form-control" name="description" id="description" required>
            </div>

            <button type="submit" class="btn btn-primary">Potvrdiť</button>
        </form>
    </div>

@endsection
