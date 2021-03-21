@extends('layouts.master')


@section('content')

    <div class="text-left">
      <a href="{{route('employees.index')}}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="firstName">Krstné meno:</label>
            <input type="text" class="form-control" name="firstName" id="firstName">
          </div>

          <div class="form-group">
            <label for="lastName">Priezvisko:</label>
            <input type="text" class="form-control" name="lastName" id="lastName">
          </div>

          <div class="form-group">
            <label for="workPosition">Pracovná pozícia:</label>
            <select class="form-control" data-live-search="true" id="workPosition" name="workPosition">
              <option disabled selected value> -- vyber pozíciu -- </option>
              @foreach ($workPositions as $position)
                  <option value="{{ $position->id }}">{{ $position->positionName }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="salary">Plat:</label>
            <input type="integer" class="form-control" name="salary" id="salary">
          </div>

          <div class="form-group">
            <label for="employedSince">Zamestnaný od:</label>
            <input type="date" value="{{ date("Y-m-d") }}" class="form-control" name="employedSince" id="employedSince">
          </div>

          <button type="submit" class="btn btn-primary">Potvrdiť</button>

    </form>

@endsection