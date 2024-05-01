@extends('layouts.app')

@section('content')
    <div class="container">
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
