@extends('layouts.master')


@section('content')
    
    {{-- ALL CATEGORIES --}}
    <div class="text-left">
      <a href="{{route('products.index')}}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>
    <h1>Kategórie produktov</h1>

    <table class="table table-striped table-sm border-bottom">
        <thead>
          <tr class="bg-dark text-white">
            <th scope="col">ID</th>
            <th scope="col">Kategória</th>
            <th scope="col"><i class="fas fa-info"></i></th>
        </tr>
        </thead>
        
        <tbody>
            @foreach ($productCategories as $category)
                <tr>
                    <th scope="row">{{ $category->id }}</th>
                    <td>{{ $category->categoryName }}</td>
                    <td>
                      <form action="{{ route('productCategories.destroy', $category) }}"  onsubmit="return confirm('Are you sure?');" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                      </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>

      <div class="d-flex justify-content-end">
        {{ $productCategories->links() }}
      </div>

    {{-- ADD CATEGORY --}}
    <form action="{{ route('productCategories.store') }}" method="POST">
      @csrf
      <h3>Pridaj novú kategóriu</h3>
      <div class="form-group">
        <label for="name">Názov:</label>
        <input type="text" class="form-control" name="name" id="name">
      </div>

      <button type="submit" class="btn btn-primary">Potvrdiť</button>
    </form>

@endsection