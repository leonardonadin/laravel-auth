@extends('mail.layouts.base')

@section('content')
    <h1>
        Verificar e-mail
    </h1>
    <p>
        Para continuar, você precisa verificar seu endereço de e-mail.
    </p>
    <p>
        E-mail: {{ $email }}
    </p>
    <p>
        Token: {{ $token }}
    </p>
    <p>
        <a href="{{ route('auth.verify-email', ['email' => $email, 'token' => $token]) }}">
            Clique aqui para verificar seu e-mail
        </a>
    </p>
@endsection
