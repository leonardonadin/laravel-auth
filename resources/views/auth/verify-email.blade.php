@extends('auth._layout')

@section('auth-content')
    <div class="auth-title">
        Verificar conta
    </div>
    <div x-data="{ type: 'email', email: '{{ $email ?? (old('email') ?? '') }}' }">
        <div class="mb-2">
            <label for="type" class="form-label">Verificar por</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="verifyByEmail" value="email"
                    x-model="type">
                <label class="form-check-label" for="verifyByEmail">
                    E-mail
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="verifyByPhone" value="phone" disabled
                    x-model="type">
                <label class="form-check-label" for="verifyByPhone">
                    Celular
                </label>
            </div>
        </div>
        <form action="{{ route('auth.verify-email') }}" method="POST">
            @csrf
            @honeypot
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <div class="input-group mb-3">
                    <input type="email" class="form-control" id="email" name="email"
                        @isset($email) x-model="email" readonly @endisset aria-describedby="button-send">
                    <button class="btn btn-outline-primary" type="submit" id="button-send">
                        Enviar token
                    </button>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="token" class="form-label">Token</label>
                <input type="text" class="form-control" id="token" name="token">
                @error('token')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-dark px-5">
                    Verificar e-mail
                </button>
            </div>
        </form>
    </div>
    <div class="mt-3 text-center">
        Não recebeu o e-mail de verificação?
    </div>
    <div class="mt-3 text-center">
        <form action="{{ route('auth.verify-email.resend') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="email" x-model="email">
            <button type="submit" class="btn btn-link p-0 m-0">
                Clique aqui para reenviar
            </button>
        </form>
    </div>
@endsection
