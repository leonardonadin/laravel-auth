<form action="{{ route('site.auth.login') }}" method="POST">
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
