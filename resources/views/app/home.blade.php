@extends('app.layouts.base')

@section('content')
    <div class="container">
        <p>Olá, {{ Auth::user()->name }}!</p>
    </div>
@endsection
