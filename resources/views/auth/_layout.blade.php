@extends('layouts.app')

@section('content')
    <div class="auth-page">
        <div class="auth-wrapper">
            <div class="logo">
                <a href="{{ route('app.home') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo">
                </a>
            </div>
            <div class="auth-container">
                @yield('auth-content')
            </div>
        </div>
        <div class="auth-background"></div>
    </div>
@endsection
