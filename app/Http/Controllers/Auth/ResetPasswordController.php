<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset form.
     *
     * @param string $token Password reset token
     */
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle the password reset process.
     */
    public function resetPassword(Request $request)
    {
        // Validate reset password request data
        $request->validate(
            [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'password_confirmation' => 'required|same:password',
            ],
            // Custom validation error messages
            [
                'token.required' => 'Token inválido ou ausente',
                'email.required' => 'O email é obrigatório',
                'email.email' => 'Informe um email válido',

                'password.required' => 'A nova senha é obrigatória',
                'password.min' => 'A nova senha deve conter no mínimo :min caracteres',
                'password.max' => 'A nova senha deve conter no máximo :max caracteres',
                'password.regex' => 'A nova senha deve conter pelo menos uma letra maiúscula, uma minúscula e um número',
                'password_confirmation.required' => 'A confirmação da nova senha é obrigatória',
                'password_confirmation.same' => 'A confirmação da nova senha seve ser igual à nova senha',
            ]
        );

        // Attempt to reset the user's password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Force update the user's password with hashing
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        // Password successfully reset
        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('success', 'Senha redefinida com sucesso! Faça login');
        }

        // Password reset failed
        return back()->withErrors([
            'email' => trans($status),
        ]);
    }
}
