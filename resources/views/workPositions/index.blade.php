@extends('layouts.master')


@section('content')
    
    {{-- ALL POSITIONS --}}
    <div class="text-left">
      <a href="{{route('employees.index')}}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>
    <h1>Work Positions</h1>
    <table class="table table-striped table-sm border-bottom">
        <thead>
          <tr class="bg-dark text-white">
            <th scope="col">ID</th>
            <th scope="col">Pozícia</th>
            <th scope="col"><i class="fas fa-info"></i></th>
        </tr>
        </thead>
        
        <tbody> 
            @foreach ($workPositions as $position)
                <tr>
                    <th scope="row">{{ $position->id }}</th>
                    <td>{{ $position->positionName }}</td>
                    <td>
                      <form action="{{ route('workPositions.destroy', $position) }}" onsubmit="return confirm('Are you sure?');" method="POST">
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
        {{ $workPositions->links() }}
      </div>

    {{-- ADD POSITION --}}
      <form action="{{ route('workPositions.store') }}" method="POST">
        @csrf
        <h3>Pridaj novú Pozíciu</h3>
        <div class="form-group">
          <label for="positionName">Názov:</label>
          <input type="text" class="form-control" name="positionName" id="positionName">
        </div>

        <button type="submit" class="btn btn-primary">Potvrdiť</button>
    </form>

@endsection