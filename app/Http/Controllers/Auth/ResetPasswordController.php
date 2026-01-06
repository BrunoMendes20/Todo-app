<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate(
            [
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'password_confirmation' => 'required|same:password',

            ],

            // errors messages
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

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),


                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Senha redefinida com sucesso! Faça login');
        }

        return back()->withErrors([
            'email' => trans($status),
        ]);
    }
}
