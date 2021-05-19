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
        <a href="{{ route('employees.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <div class="box box-big col col-md-10 col-lg-8">
        <h2>Pridaj zamestnanca</h2>

        <form action="{{ route('employees.store') }}" method="POST">
            @csrf

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">Meno</span>
                </div>
                <input type="text" class="form-control" maxlength="20" name="firstName" id="firstName" required>
            </div>

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">Priezvisko</span>
                </div>
                <input type="text" class="form-control" maxlength="20" name="lastName" id="lastName" required>
            </div>

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="workPosition">Pozícia</label>
                </div>
                <select class="form-control" title="-- vyber pozíciu --" data-size="5" data-live-search="true" id="workPosition" name="workPosition">
                    @foreach ($workPositions as $position)
                        <option value="{{ $position->id }}">{{ $position->positionName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text">Plat</span>
                </div>
                <input type="number" step="0.01" min="0" class="form-control" name="salary" id="salary" required>
            </div>

            <div class="from-group mb-4">
                <label for="employedSince">Zamestnaný od:</label>
                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="employedSince"
                    id="employedSince" required>
            </div>

            <button type="submit" class="btn btn-primary">Potvrdiť</button>
        </form>
    </div>

@endsection
