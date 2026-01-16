<x-layout-guest pageTitle="Cadastro">
    <x-auth-card>
        <form action="{{ route('users.store') }}" method="post" novalidate>
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
                <label for="name" class="form-label">Nome</label>
                <input type="text"class="form-control" name="name" value="{{ old('name') }}" required>

            </div>
            @error('name')
                <div class="invalid-feedback d-block fade show auto-close">
                    {{ $message }}
                </div>
            @enderror

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

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar senha</label>
                <input type="password" class="form-control" name="password_confirmation" required>

            </div>
            @error('password_confirmation')
                <div class="invalid-feedback d-block fade show auto-close">
                    {{ $message }}
                </div>
            @enderror

            <button type="submit" class="btn mt-3 w-100">Inscreva-se</button>
        </form>
        <x-slot:footer>
            Já tem uma conta ? <a href="{{ route('login') }}">Faça login</a>
        </x-slot:footer>
    </x-auth-card>

</x-layout-guest>
