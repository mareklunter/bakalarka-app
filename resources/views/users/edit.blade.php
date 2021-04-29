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
    
    <h1>Úprava profilu</h1>
    
    <form method="post" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PACTH')

        <input type="text" name="name" value="{{ $user->name }}" />

        <input type="email" name="email" value="{{ $user->email }}" />

        <input type="password" name="password" />

        <input type="password" name="password_confirmation" />

        <button class="btn btn-primary" type="submit">Potvrdiť</button>
    </form>

    
    {{-- $table->string('name', 50);
    $table->string('street', 50)->nullable();
    $table->string('houseNumber', 10)->nullable();
    $table->string('postalCode', 10)->nullable();
    $table->string('city', 50)->nullable();
    $table->string('email', 50)->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password', 50); --}}

@endsection
