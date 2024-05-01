@extends('layouts.base')

@section('base')

    <header class="mb-4">
        <div class="border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-center justify-content-md-between py-3">
                    <div class="col-md-3 mb-2 mb-md-0 me-md-auto">
                        <a href="{{ route('app.home') }}" class="d-inline-flex link-body-emphasis text-decoration-none">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="img-fluid" />
                        </a>
                    </div>
                    <div class="col-md-3 text-end">
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark rounded-0 btn-sm">Sair</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
@endsection
