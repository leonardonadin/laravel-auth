@extends('auth._layout')

@section('auth-content')
    <div class="auth-title">
        Cadastre-se
    </div>
    <x-auth.register-form />
    <div class="mt-3 text-center">
        Já é cliente?
    </div>
    <div class="text-center">
        <a href="{{ route('auth.login') }}" class="fw-bold fs-5 text-decoration-none">
            Fazer login
        </a>
    </div>
@endsection
