@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center justify-content-end min-vh-100">
            <div class="col-12 col-md-5">
                <h1 class="mb-4">
                    Entrar
                </h1>
                <form action="">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
