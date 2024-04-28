@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center justify-content-end min-vh-100">
            <div class="col-12 col-md-5">
                <h1 class="mb-4">
                    Entrar
                </h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <x-site.auth.login-form />
                <div class="mt-4">
                    <a href="{{ route('site.auth.password.forgot') }}">Esqueceu sua senha?</a>
                </div>
            </div>
        </div>
    </div>
@endsection
