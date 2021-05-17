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
    
    <div class="box box-big col col-md-10 col-lg-8" id="userInfoEdit">
        <h1>Profil</h1>
        <form method="post" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PATCH')
            
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Názov</span>
                </div>
                <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Email</span>
                </div>
                <fieldset class="form-control" disabled>{{ $user->email }}</fieldset>
            </div>

            {{-- <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Názov</span>
                </div>
                <input type="text" class="form-control" name="address" value="{{ $user->address }}" required>
            </div> --}}

            {{-- <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Názov</span>
                </div>
                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}" required>
            </div> --}}
            
            <button class="btn btn-primary" type="submit">Uložiť</button>
        </form>

        <div class="text-left">
            <a href="#" class="btn btn-light" id="showUserPassEdit">Zmeniť heslo</a>
        </div>
    </div>

    <div class="box box-big col col-md-10 col-lg-8" id="userPassEdit">
        <h1>Profil</h1>
        <form method="post" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PATCH')

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Staré heslo</span>
                </div>
                <input type="password" class="form-control" name="old_pass" required>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Nové heslo</span>
                </div>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Zopakuj heslo</span>
                </div>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>
            
            <button class="btn btn-primary" type="submit">Uložiť</button>
        </form>

        <div class="text-left">
            <a href="#" class="btn btn-light" id="showUserInfoEdit">Zmeniť ostatné údaje</a>
        </div>
    </div>


@endsection
