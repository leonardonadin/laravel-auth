@extends('auth.layouts.base')

@section('content')
    <div class="auth-title">
        Recuperar senha
    </div>
    <div x-data="{ login: '{{ $login ?? (old('login') ?? '') }}' }">
        <form action="{{ route('auth.password.forgot') }}" method="POST">
            @csrf
            @honeypot
            <div class="mb-2">
                <label for="login" class="form-label">E-mail ou celular</label>
                <input type="login" class="form-control @error('login') is-invalid @enderror"
                    id="login" name="login" value="{{ old('login') ?? $login }}"
                    x-model="login">
                @error('login')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="text-end">
                <button type="button" class="btn btn-link btn-sm text-decoration-none" x-on:click="$refs.resendForm.submit()"
                    x-bind:disabled="!login">
                    Não recebeu? Reenviar
                </button>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-dark px-5">
                    Recuperar
                </button>
            </div>
        </form>
        <form x-ref="resendForm" action="{{ route('auth.password.forgot.resend') }}" method="POST">
            @csrf
            @honeypot
            <input type="hidden" name="login" x-model="login">
        </form>
    </div>
    <div class="mt-3 text-center">
        <a href="{{ route('auth.login') }}" class="text-decoration-none">
            Voltar para o login
        </a>
    </div>
@endsection
