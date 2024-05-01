@extends('auth.layouts.base')

@section('content')
    <div class="auth-title">
        Ativação de conta
    </div>
    <div x-data="{ email: '{{ $email ?? (old('email') ?? '') }}' }">
        <form action="{{ route('auth.verify-email') }}" method="POST">
            @csrf
            @honeypot
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <div class="input-group-custom mb-3">
                    <input type="email" class="form-control" id="email" name="email"
                        @isset($email) x-model="email" readonly @endisset aria-describedby="button-send">
                    <button class="button-append" type="submit" id="button-send">
                        Enviar/Reenviar
                    </button>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-5">
                <label for="token" class="form-label">Código de ativação</label>
                <input type="text" class="form-control" id="token" name="token">
                @error('token')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center mt">
                <button type="submit" class="btn btn-dark px-5">
                    Ativar conta
                </button>
            </div>
            <div class="mt-3 text-center">
                <a href="{{ route('auth.login') }}" class="text-decoration-none">
                    Voltar para o login
                </a>
            </div>
        </form>
    </div>
@endsection
