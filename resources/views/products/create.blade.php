@extends('layouts.master')


@section('content')
    <div class="text-left">
      <a href="{{route('products.index')}}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Názov:</label>
            <input type="text" class="form-control" name="name" id="name">
          </div>

          <div class="form-group">
            <label for="price">Cena:</label>
            <input type="text" class="form-control" name="price" id="price">
          </div>

          <div class="form-group">
            <label for="category">Kategória:</label>
            <select class="form-control" data-live-search="true" id="category" name="category" >
              @foreach ($productCategories as $category)
                  <option value="{{ $category->id }}">{{ $category->categoryName }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="description">Popis:</label>
            <input type="integer" class="form-control" name="description" id="description">
          </div>

          <button type="submit" class="btn btn-primary">Potvrdiť</button>

    </form>

@endsection