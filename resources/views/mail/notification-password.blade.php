<x-layout-email>
    <h3>Recuperação de Senha</h3>
    <p>Olá <strong>{{ $user->name }}</strong>, para recuperar a senha de usuário, clique no link abaixo:</p>
    <p><a href="{{ $resetLink }}">Redefinir Senha</a></p>
    <p>Se você não solicitou a redefinição de senha, por favor, ignore este email.</p>
    <p>Atenciosamente,<br />Equipe de Suporte</p>
</x-layout-email>
