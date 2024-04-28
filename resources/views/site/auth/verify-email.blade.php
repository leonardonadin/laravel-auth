@extends('layouts.app')

@section('content')
    <div class="container" x-data="{ email: '{{ $email ?? (old('email') ?? '') }}' }">
        <div class="row align-items-center justify-content-end min-vh-100">
            <div class="col-12 col-md-5">
                <h1 class="mb-4">
                    Verificar e-mail
                </h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('message'))
                    <div class="alert alert-info">
                        {{ session('message') }}
                    </div>
                @endif
                <form action="{{ route('site.auth.verify-email') }}" method="POST">
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
                    <div class="mb-3">
                        <label for="token" class="form-label">Token</label>
                        <input type="text" class="form-control" id="token" name="token">
                        @error('token')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            Verificar e-mail
                        </button>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    Não recebeu o e-mail de verificação?
                </div>
                <div class="mt-3 text-center">
                    <form action="{{ route('site.auth.verify-email.resend') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="email" x-model="email">
                        <button type="submit" class="btn btn-link p-0 m-0">
                            Clique aqui para reenviar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
