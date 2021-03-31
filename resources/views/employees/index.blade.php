@extends('layouts.master')


@section('content')
    
    <h1>Zamestnanci</h1>
    <table class="table table-striped border-bottom">
        <thead class="bg-dark text-white">
          <tr>
            <th scope="col">@sortablelink('id', 'Id')</th>
            <th scope="col">@sortablelink('lastName', 'Celé meno')</th>
            <th scope="col">@sortablelink('salary', 'Plat')</th>
            <th scope="col">Pozícia</th>
            <th scope="col">@sortablelink('created_at', 'Pracuje od')</th>
            <th scope="col"><i class="fas fa-info"></i></th>
          </tr>
        </thead>
        
        <tbody>

            @foreach ($employees as $employee)
                <tr>
                    <th scope="row">{{ $employee->id }}</th>
                    <td>{{ $employee->firstName . " " .  $employee->lastName}}</td>
                    <td>{{ $employee->salary }}</td>
                    <td>{{ $employee->workPosition()->withTrashed()->get()->first()->positionName }}</td> 
                    {{-- cast DATE to DATETIME and then to 'd.m.Y' format -> argument of date_format() must be DATETIME--}}
                    <td>{{ date_format(DateTime::createFromFormat('Y-m-d', $employee->employed_since), 'd.m.Y') }}</td>

                    <td class="actions-2">
                      <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary btn-sm"><i class="far fa-edit"></i></a>
                      {{-- DELETE ITEM button/form--}}
                      <form action="{{ route('employees.destroy', $employee) }}"  onsubmit="return confirm('Are you sure?');" method="POST">
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
        {!! $employees->appends(\Request::except('page'))->render() !!}
      </div>

      <a href="{{ route('employees.shifts') }}" class="btn btn-primary">Smeny</a>
      <a href="{{ route('employees.create') }}" class="btn btn-info">Nový zamestnanec</a>
      <a href="{{ route('workPositions.index') }}" class="btn btn-warning">Pracovné pozície</a>
        

@endsection