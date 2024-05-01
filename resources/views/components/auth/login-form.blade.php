<form action="{{ route('auth.login') }}" method="POST">
    @csrf
    @honeypot
    <div x-data="{ hidePassword: true }">
        <div class="mb-3">
            <label for="login" class="form-label">E-mail ou Celular</label>
            <input type="login" class="form-control @error('login') is-invalid @enderror" id="login" name="login">
        </div>
        <div class="mb-2">
            <label for="password" class="form-label">Senha</label>
            <div class="input-group-custom">
                <input x-bind:type="hidePassword ? 'password' : 'text'" class="form-control @error('login') is-invalid @enderror"
                    id="password" name="password" aria-describedby="button-addon1">
                <button class="button-append" type="button" id="button-addon1"
                    x-on:click="hidePassword = !hidePassword">
                    <span class="fa" x-bind:class="hidePassword ? 'fa-eye-slash' : 'fa-eye'"></span>
                </button>
            </div>
        </div>
        <div class="text-end">
            <a href="{{ route('auth.password.forgot') }}" class="text-decoration-none">
                Esqueci minha senha
            </a>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-dark px-5">
                Conectar
            </button>
        </div>
    </div>
</form>
