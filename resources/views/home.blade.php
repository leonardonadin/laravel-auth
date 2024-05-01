@extends('layouts.base')

@section('base')
    <div class="container">
        <div class="my-3 text-center">
            <a href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo">
            </a>
        </div>
        <h1 class="mb-5 text-center">
            Bem-vindo
        </h1>
        <div class="row align-items-center justify-content-between">
            <div class="col-12 col-md-5">
                <h3 class="text-center">
                    Já é cliente?
                </h3>
                <a href="{{ route('auth.login') }}" class="btn btn-dark w-100 mb-3">
                    Entrar
                </a>
            </div>
            <div class="col-12 col-md-5">
                <h3 class="text-center">
                    Ainda não tem uma conta?
                </h3>
                <a href="{{ route('auth.register') }}" class="btn btn-dark w-100 mb-3">
                    Cadastre-se
                </a>
            </div>
        </div>
    </div>
@endsection
