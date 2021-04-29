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

    <form method="post" action="{{ route('users.edit', $user) }}">
        @csrf
        @method('PACTH')

        <input type="text" name="name" value="{{ $user->name }}" />

        <input type="email" name="email" value="{{ $user->email }}" />

        <input type="password" name="password" />

        <input type="password" name="password_confirmation" />

        <button type="submit">Send</button>
    </form>

@endsection
