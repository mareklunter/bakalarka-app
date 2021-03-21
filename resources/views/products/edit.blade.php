@extends('layouts.master')


@section('content')

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT') 
        
        <div class="form-group">
            <label for="name">Názov:</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $product->name }}">
        </div>

        <div class="form-group">
            <label for="price">Cena:</label>
            <input type="text" class="form-control" name="price" id="price" value="{{ $product->price }}">
        </div>

        <div class="form-group">
            <label for="category">Kategória:</label>
            <select class="form-control" data-live-search="true" id="category" name="category">

                @foreach ($productCategories as $category)
                    @if ( $category->id == $product->product_category_id)

                        @if ( $category->trashed() )
                            <option value="{{ $category->id }}" disabled selected>{{ $category->categoryName }}</option>
                        @else
                            <option value="{{ $category->id }}" selected>{{ $category->categoryName }}</option>
                        @endif
                       
                    @elseif ( ! $category->trashed() )
                        <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                    @endif
                @endforeach

            </select>
        </div>

        <div class="form-group">
            <label for="description">Popis:</label>
            <input type="integer" class="form-control" name="description" id="description" value="{{ $product->description }}">
        </div>

        <button type="submit" class="btn btn-primary btn-sm">Potvrdiť</button>
    </form>

@endsection