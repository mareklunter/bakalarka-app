@extends('layouts.master')


@section('content')

    <div class="text-left">
      <a href="{{route('employees.index')}}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <form action="{{ route('employees.update', $employee) }}" method="POST">
        @csrf
        @method('PUT') 
        
        <div class="form-group">
            <label for="firstName">Krstné meno:</label>
            <input type="text" class="form-control" name="firstName" id="firstName" value="{{ $employee->firstName }}">
          </div>

          <div class="form-group">
            <label for="lastName">Priezvisko:</label>
            <input type="text" class="form-control" name="lastName" id="lastName" value="{{ $employee->lastName }}">
          </div>

          <div class="form-group">
            <label for="workPosition">Pracovná pozícia:</label>
            <select class="form-control" data-live-search="true" id="workPosition" name="workPosition">

                @foreach ($workPositions as $position)

                    @if ( $position->id == $employee->work_position_id)
                      {{-- options are not-trashed positions except for already ordered item which was trashed  --}}
                      @if ( $position->trashed() )
                          <option value="{{ $position->id }}"  disabled selected>{{ $position->positionName }}</option>
                      @else
                          <option value="{{ $position->id }}" selected>{{ $position->positionName }}</option>
                      @endif

                    @elseif ( ! $position->trashed() )
                        <option value="{{ $position->id }}">{{ $position->positionName }}</option>
                    @endif

                @endforeach

            </select>
          </div>

          <div class="form-group">
            <label for="salary">Plat:</label>
            <input type="integer" class="form-control" name="salary" id="salary" value="{{ $employee->salary }}">
          </div>

          <div class="form-group">
            <label for="employedSince">Zamestnaný od:</label>
            <input type="date" value="{{ date("Y-m-d") }}" class="form-control" name="employedSince" id="employedSince" value="{{ $employee->employedSince }}">
          </div>

        <button type="submit" class="btn btn-primary btn-sm">Potvrdiť</button>
    </form>

@endsection