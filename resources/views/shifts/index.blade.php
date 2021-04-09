@extends('layouts.master')

@section('content')

    <div class="text-left">
        <a href="{{route('employees.index')}}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>


    <table class="table table-striped table-sm border-bottom">
        <thead>
          <tr class="bg-dark text-white">
            <th scope="col">Zamestnanec</th>  
            @for ($i = 0; $i < 7; $i++)
                <th scope="col">den {{$i}}</th>  
            @endfor 
        </tr>
        </thead>
        
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                    <td>{{$employee->firstName . ' ' . $employee->lastName}}</td>
                    @for ($i = 0; $i < 7; $i++)
                        <td>
                            <p>ne/ma sichtu</p>
                        </td>
                    @endfor 
                    {{-- @foreach ($dayOfWeek) --}}
                        {{-- <td>
                            $employee->haveShift($date)
                        </td> --}}
                    {{-- @endforeach --}}
                </tr>
            @endforeach
        </tbody>
      </table>


    <form action="{{ route('shifts.store') }}" method="POST">
        @csrf
        <h3>Pridaj smenu</h3>
        <div class="form-group">
            <label for="employee_id">Zamestnanec:</label>
            <select class="form-control" data-live-search="true" id="employee_id" name="employee_id">
            <option disabled selected value> -- vyber zamestnanca -- </option>
                @foreach ($employees as $employee)
                  <option value="{{ $employee->id }}">{{ $employee->firstName. ' ' .$employee->lastName }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
          <label for="startDate">Od:</label>
          <input type="date" class="form-control" name="startDate" id="startDate">
        </div>

        <div class="form-group">
          <label for="endDate">Do:</label>
          <input type="date" class="form-control" name="endDate" id="endDate">
        </div>

        <button type="submit" class="btn btn-primary">Potvrdiť</button>
    </form>
    

@endsection