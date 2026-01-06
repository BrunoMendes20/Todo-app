<x-layout-guest pageTitle="Recuperar senha">
    <x-auth-card>
        @if (!session('status'))
            <p>Para recuperar a sua senha, por favor indique o seu email. Você irá receber um email com um link para
                recuperação.</p>

            <form action="{{ route('password.email') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label mb-2">Email</label>
                    <input type="email" class="form-control" name="email" required>
                    @error('email')
                        <div class="invalid-feedback d-block fade show auto-close">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('login') }}">Já sei a minha senha</a>
                    <button type="submit" class="btn">Enviar email</button>

                </div>

            </form>
        @else
        @endif
    </x-auth-card>
</x-layout-guest>
