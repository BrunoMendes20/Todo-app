<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Display the "forgot password" form.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle the password reset link request.
     * Sends a reset email to the provided address.
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email input
        $request->validate(
            [
                'email' => ['required', 'email'],
            ],
            [
                'email.required' => 'Email é obrigatório',
                'email.email' => 'O email deve ser um endereço válido',
            ]
        );

        // Send the password reset link to the user's email
        Password::sendResetLink($request->only('email'));

        // Show confirmation view after sending the email
        return view('auth.email-sent');
    }
}
