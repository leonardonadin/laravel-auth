@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center justify-content-end min-vh-100">
            <div class="col-12 col-md-5">
                <h1 class="mb-4">
                    Registre-se
                </h1>
                <x-site.auth.register-form />
            </div>
        </div>
    </div>
@endsection
