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
        <a href="{{ route('employees.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <div class="box box-big col col-md-10 col-lg-8">
        <h2>Upraviť údaje zamestnanca</h2>
        <form action="{{ route('employees.update', $employee) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Krstné meno</span>
                </div>
                <input type="text" class="form-control" maxlength="20" name="firstName" id="firstName" value="{{ $employee->firstName }}" required>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Priezvisko</span>
                </div>
                <input type="text" class="form-control" maxlength="20" name="lastName" id="lastName" value="{{ $employee->lastName }}"
                    required>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="workPosition">Pracovná pozícia</label>
                </div>

                <select class="form-control" data-live-search="true" id="workPosition" name="workPosition">
                    @foreach ($workPositions as $position)
                        @if ($position->id == $employee->work_position_id)
                            {{-- options are not-trashed positions except for already ordered item which was trashed --}}
                            @if ($position->trashed())
                                <option value="{{ $position->id }}" disabled selected>{{ $position->positionName }}
                                </option>
                            @else
                                <option value="{{ $position->id }}" selected>{{ $position->positionName }}</option>
                            @endif

                        @elseif ( ! $position->trashed() )
                            <option value="{{ $position->id }}">{{ $position->positionName }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Plat</span>
                </div>
                <input type="number" step="0.01" min="0" class="form-control" name="salary" id="salary"
                    value="{{ $employee->salary }}" required>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Zamestnaný od</span>
                </div>
                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="employedSince"
                    id="employedSince" value="{{ $employee->employedSince }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Potvrdiť</button>
        </form>
    </div>

@endsection
