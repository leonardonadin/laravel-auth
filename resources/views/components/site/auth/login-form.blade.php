<form action="{{ route('site.auth.login') }}" method="POST">
    @csrf
    @honeypot
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control @error('email') is-invalid @enderror"
            id="email" name="email">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Entrar</button>
    </div>
</form>
