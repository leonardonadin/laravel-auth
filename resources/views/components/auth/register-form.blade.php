<form action="{{ route('auth.register') }}" method="POST">
    @csrf
    @honeypot
    <div x-data="{ phoneNumber: @js(old('phone_number') ?? ''), phoneCode: @js(old('phone_code') ?? '55'), phoneFlag: 'br' }">
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                required value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" required value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Telefone</label>
            <input type="hidden" name="phone" x-bind:value="phoneCode + phoneNumber">
            <input type="hidden" name="phone_code" x-model="phoneCode">
            <div class="input-group-custom">
                <button class="button-prepend dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span class="fi" x-bind:class="'fi-' + phoneFlag"></span>
                    <span x-text="'+' + phoneCode"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <div class="dropdown-item" @click="phoneCode = '55'; phoneFlag = 'br'">
                            <span class="fi fi-br"></span> (+55)
                        </div>
                        <div class="dropdown-item" @click="phoneCode = '54'; phoneFlag = 'ar'">
                            <span class="fi fi-ar"></span> (+54)
                        </div>
                    </li>
                </ul>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone_number" required
                    name="phone_number" x-model="phoneNumber" x-mask:dynamic="$input.length <= 14 ? '(99) 9999 9999' : '(99) 99999 9999'">
            </div>
            @error('phone')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" required>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Repetir Senha</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                required>
        </div>
        <div class="form-check">
            <input class="form-check-input @error('accepted_terms') is-invalid @enderror"
                type="checkbox" id="acceptTerms" name="accepted_terms" >
            <label class="form-check-label" for="acceptTerms">
                Eu li e aceito a
                <a href="#" target="_blank" class="text-info">
                    Política de Privacidade
                </a>
            </label>
        </div>
        <div class="mt-4 text-center">
            <p>
                Quero receber ofertas, novidades, <br />
                conteúdos informativos e publicitários.
            </p>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input @error('accepted_newsletter') is-invalid @enderror"
                            type="radio" name="accepted_newsletter" id="acceptNewsletter" value="1" required>
                        <label class="form-check-label" for="acceptNewsletter">
                            Sim
                        </label>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input @error('accepted_newsletter') is-invalid @enderror"
                            type="radio" name="accepted_newsletter" id="declineNewsletter" value="0" required>
                        <label class="form-check-label" for="declineNewsletter">
                            Não
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5">Cadastrar</button>
        </div>
    </div>
</form>
