<x-layout-guest page-title="Login">
    <x-auth-card>
        <form action="{{ route('login.store') }}" method="post" novalidate>
            @csrf

            @if (session('error'))
                <div class="alert alert-danger auto-close">
                    {{ session('error') }}

                </div>
            @endif

            @if (session('success'))
                <div id="sucess-alert" class="alert alert-success fade show auto-close">
                    {{ session('success') }}

                </div>
            @endif

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email"class="form-control" name="email" value="{{ old('email') }}" required>

            </div>
            @error('email')
                <div class="invalid-feedback d-block fade show auto-close">
                    {{ $message }}
                </div>
            @enderror

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" name="password" required>

            </div>
            @error('password')
                <div class="invalid-feedback d-block fade show auto-close">
                    {{ $message }}
                </div>
            @enderror

            <div class="forgot d-flex justify-content-end">
                <a href="{{ route('password.request') }}">Esqueceu sua senha?</a>

            </div>

            <button type="submit" class="btn mt-3 w-100">Entrar</button>
        </form>

        <x-slot:footer>
            Não tem uma conta ? <a href="{{ route('register') }}">Cadastre-se</a>
        </x-slot:footer>
    </x-auth-card>

</x-layout-guest>
