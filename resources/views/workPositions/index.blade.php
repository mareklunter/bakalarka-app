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

    <div class="float-left">
        <a href="{{ route('employees.index') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Späť</a>
    </div>

    <h1 class="page-header mb-4">Pracovné pozície</h1>


    <div class="row justify-content-around">
        {{-- ALL POSITIONS --}}
        <table class="table table-striped table-sm table-bordered col-11 col-md-7 order-md-last">
            <thead>
                <tr class="bg-dark text-white">
                    <th scope="col">Pozícia</th>
                    <th scope="col"><i class="fas fa-info"></i></th>
                </tr>
            </thead>

            <tbody>
                @if ($workPositions->isEmpty())
                    <tr>
                        <td colspan="2">
                            Zatiaľ neboli pridané žiadne prac. pozície.
                        </td>
                    </tr>
                @endif

                @foreach ($workPositions as $position)
                    <tr>
                        <td>{{ $position->positionName }}</td>
                        <td>
                            <form action="{{ route('workPositions.destroy', $position) }}"
                                onsubmit="return confirm('Are you sure?');" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i
                                        class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ADD POSITION --}}
        <div class="box box-small col-11 col-md-4 order-md-first">
            <form action="{{ route('workPositions.store') }}" method="POST">
                @csrf
                <h3>Pridaj novú pozíciu</h3>
                <div class="input-group my-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Názov</span>
                    </div>
                    <input type="text" class="form-control" maxlength="20" name="positionName" id="positionName" required>
                </div>

                <button type="submit" class="btn btn-primary">Potvrdiť</button>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-end">
        {{ $workPositions->links() }}
    </div>

@endsection
