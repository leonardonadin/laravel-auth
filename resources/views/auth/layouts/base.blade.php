@extends('layouts.base')

@section('base')
    <div class="auth-page">
        <div class="logo">
            <a href="{{ route('app.home') }}">
                <img src="{{ asset('img/logo_white.png') }}" alt="Logo" class="d-md-none d-block" />
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="d-md-block d-none" />
            </a>
        </div>
        <div class="auth-wrapper">
            <div class="auth-container">
                @yield('content')
            </div>
        </div>
        <div class="auth-background"></div>
    </div>
@endsection
