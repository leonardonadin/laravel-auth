@extends('layouts.base')

@section('base')
    <div class="container">
        <div class="my-3 text-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo">
            </a>
        </div>
        <h1 class="text-center">
            Bem-vindo
        </h1>
        <div class="row align-items-center justify-content-between min-vh-100">
            <div class="col-12 col-md-5">
                <h2>
                    Entrar
                </h2>
                <x-auth.login-form />
            </div>
            <div class="col-12 col-md-5">
                <h2>
                    Registre-se
                </h2>
                <x-auth.register-form />
            </div>
        </div>
    </div>
@endsection
