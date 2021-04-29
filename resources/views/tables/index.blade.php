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

    <h1>Obsadenosť</h1>

    @if ($tables->isEmpty())
        <div class="box box-big col col-md-10 py-4 px-2 row justify-content-center">
            <p class="my-0">Zatiaľ neboli vytvorené žiadne stoly.</p>
        </div>
    @else
        <div class="box box-big col col-md-10 py-4 px-2 row justify-content-start">
            @foreach ($tables as $table)
                <div class="table-box">
                    <div class="tag">{{ $table->tag }}</div>

                    <div class="{{ $table->type }}"></div>

                    <div>
                        <p class="seats">Počet miest: {{ $table->seats }}</p>

                        <form class="float-right" action="{{ route('tables.destroy', $table) }}"
                            onsubmit="return confirm('Are you sure?');" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </form>

                        Stav:
                        @if ($table->occupied)
                            <span class="badge badge-danger">Obsadený</span>
                        @else
                            <span class="badge badge-success">Voľný</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="box box-big col col-md-10 col-lg-8 mt-4">
        <h3 class="mb-4">Pridať stôl</h3>
        <form action="{{ route('tables.store') }}" method="POST">
            @csrf

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">Označenie</span>
                </div>
                <input type="text" class="form-control" name="tag" id="tag" placeholder="Stôl č.12" required>
            </div>

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text">Počet miest</span>
                </div>
                <input type="number" min="1" class="form-control" name="seats" id="seats" required>
            </div>

            <div class="input-group mb-4">
                <div class="input-group-prepend">
                    <span class="input-group-text" for="type">Typ stola</span>
                </div>
                <select class="form-control" id="type" name="type">
                    <option value="square">Štvorcový</option>
                    <option value="circle">Okrúhly</option>
                    <option value="rectangle">Obdlžníkový</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Potvrdiť</button>
        </form>
    </div>
@endsection
