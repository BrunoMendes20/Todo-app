<x-layout-guest pageTitle="Redefinir senha">
    <x-auth-card>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ request('email') }}">

            <div class="mb-3">
                <label for="password" class="form-label">Definir nova senha</label>
                <input type="password" class="form-control" name="password">

                @error('password')
                    <div class="invalid-feedback d-block fade show auto-close">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirm" class="form-label">Confirme a Nova Senha</label>
                <input type="password" class="form-control" name="password_confirmation">
                @error('password_confirmation')
                    <div class="invalid-feedback d-block fade show auto-close">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-0">
                <div class="col">
                    <a href="{{ route('login') }}">Não quero alterar a senha</a>

                </div>
                <div class="col text-end">
                    <button type="submit" class="btn">
                        Redefinir Senha
                    </button>

                </div>
            </div>
        </form>
    </x-auth-card>
</x-layout-guest>
