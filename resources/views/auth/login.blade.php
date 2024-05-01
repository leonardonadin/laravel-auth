@extends('auth._layout')

@section('auth-content')
    <div class="auth-title">
        Login
    </div>
    <x-auth.login-form />
    <div class="mt-3 text-center">
        Ainda não é cliente?
    </div>
    <div class="text-center">
        <a href="{{ route('auth.register') }}" class="fw-bold fs-5 text-decoration-none">
            Criar conta
        </a>
    </div>
@endsection
