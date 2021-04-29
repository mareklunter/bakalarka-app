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

    <div class="d-flex justify-content-end mb-2">
        <div class="btn-group" role="group" id="time-period">
            <a href="{{ route('shifts.index', $startWeek->format('Y-m-d')) }}/previous" class="btn btn-primary"><i
                    class="fas fa-arrow-left"></i></a>
            <button type="button" class="btn btn-secondary"
                disabled>{{ $startWeek->format('d.m') . '-' . $endWeek->format('d.m') }}</button>
            <a href="{{ route('shifts.index', $startWeek->format('Y-m-d')) }}/next" class="btn btn-primary"><i
                    class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <table class="table table-bordered table-sm" id="shift-table">
        <thead>
            <tr class="bg-dark text-white">
                <th scope="col">Zamestnanec</th>
                @foreach ($week as $day)
                    <th scope="col">{{ $day->format('d.m') }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <th>{{ $employee->firstName . ' ' . $employee->lastName }}</th>

                    @foreach ($week as $day)
                        @if ($shift = $employee->haveShift($day))
                            <td class="green">
                                <form action="{{ route('shifts.destroy', $shift) }}"
                                    onsubmit="return confirm('Are you sure?');" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn"> {{ $shift->description ?? '...' }} </button>
                                </form>
                            </td>
                        @else
                            <td class="grey">
                                {{-- blank --}}
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <span class="hint">Kliknutím na políčko smeny sa zruší.</span>

    <div class="box box-big col col-md-10 col-lg-8 mt-4">
        <h3>Pridaj smenu</h3>

        <form action="{{ route('shifts.store') }}" method="POST">
            @csrf
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="employee_id">Zamestnanec</label>
                </div>
    
                <select class="form-control" data-live-search="true" id="employee_id" name="employee_id" required>
                    <option disabled selected> -- vyber zamestnanca -- </option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->firstName . ' ' . $employee->lastName }}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">Od</span>
                </div>
                <input type="date" class="form-control" min="{{ $startWeek->format('Y-m-d') }}" name="startDate"
                    id="startDate" required>
            </div>
    
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">Do</span>
                </div>
                <input type="date" class="form-control" name="endDate" id="endDate" required>
            </div>
    
            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">Popis</span>
                </div>
                <input type="text" class="form-control" name="description" id="description">
            </div>
    
            <button type="submit" class="btn btn-primary">Potvrdiť</button>
        </form>
    </div>


@endsection