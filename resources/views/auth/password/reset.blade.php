@extends('auth.layouts.base')

@section('content')
    <div class="auth-title">
        Redefinir senha
    </div>
    <form action="{{ route('auth.password.reset', ['token' => $token]) }}" method="POST"
        x-data="{ hidePassword: true, hideConfirmPass: true }">
        @csrf
        @honeypot
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror"
                id="email" name="email" value="{{ old('email') ?? $email }}">
            @error('email')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <div class="input-group-custom">
                <input x-bind:type="hidePassword ? 'password' : 'text'" class="form-control @error('login') is-invalid @enderror"
                    id="password" name="password" aria-describedby="button-addon1">
                <button class="button-append" type="button" id="button-addon1"
                    x-on:click="hidePassword = !hidePassword">
                    <span class="fa" x-bind:class="hidePassword ? 'fa-eye-slash' : 'fa-eye'"></span>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="passwordConfirmation" class="form-label">Repetir Senha</label>
            <div class="input-group-custom">
                <input x-bind:type="hideConfirmPass ? 'password' : 'text'" class="form-control @error('login') is-invalid @enderror"
                    id="passwordConfirmation" name="password_confirmation" aria-describedby="button-addon1" required>
                <button class="button-append" type="button" id="button-addon1"
                    x-on:click="hideConfirmPass = !hideConfirmPass">
                    <span class="fa" x-bind:class="hideConfirmPass ? 'fa-eye-slash' : 'fa-eye'"></span>
                </button>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Enviar</button>
        </div>
    </form>
@endsection
