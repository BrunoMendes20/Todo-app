<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Show the user registration form.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration and persist data.
     */
    public function store(Request $request)
    {
        // Validate incoming registration data
        $request->validate(
            [
                'name' => 'required|min:3|max:30|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'password_confirmation' => 'required|same:password',
            ],
            // Custom validation error messages
            [
                'name.required' => 'O nome é obrigatório',
                'name.min' => 'O nome deve ter pelo :min caracteres',
                'name.max' => 'O nome deve ter pelo :max caracteres',
                'name.unique' => 'Esse nome não pode ser usado',
                'email.required' => 'Email é obrigatório',
                'email.email' => 'Email inválido',
                'email.unique' => 'Email não pode ser usado',
                'password.required' => 'Senha é obrigatória',
                'password.min' => 'Senha deve ter pelo menos :min caracteres',
                'password.max' => 'Senha deve ter no máximo :max caracteres',
                'password.regex' => 'A senha deve conter pelo menos uma letra maiúscula, uma minúscula e um número.',
                'password_confirmation.required' => 'Confirmação de senha é obrigatória',
                'password_confirmation.same' => 'As senhas não coincidem',
            ]
        );

        // Create a new user with encrypted password
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect to login page with success message
        return redirect()
            ->route('login')
            ->with('success', 'Conta criada com sucesso! Faça login.');
    }

    /**
     * Show the login form.
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Handle login request and authenticate the user.
     */
    public function loginSubmit(Request $request)
    {
        // Validate login credentials
        $credentials = $request->validate(
            [
                'email' => 'required|string|email',
                'password' => 'required|string',
            ],
            // Custom validation error messages
            [
                'email.required' => 'Email é obrigatório',
                'email.email' => 'Email inválido',
                'password.required' => 'Senha é obrigatória',
                'password.string' => 'Senha inválida',
            ]
        );

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            return redirect()->route('home');
        }

        // Authentication failed: return with error message
        return back()
            ->with('error', 'Email ou senha inválidos')
            ->onlyInput('email');
    }

    /**
     * Log out the authenticated user and destroy the session.
     */
    public function destroy(Request $request)
    {
        // Log the user out
        Auth::logout();

        // Invalidate and regenerate session token for security
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
