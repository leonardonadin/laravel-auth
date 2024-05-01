@extends('app.layouts.base')

@section('content')
    <div class="container">
        <p>Olá, {{ Auth::user()->name }}!</p>
        <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Sair</button>
        </form>
    </div>
@endsection
