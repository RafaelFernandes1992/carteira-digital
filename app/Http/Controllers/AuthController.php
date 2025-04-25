<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\LoginOldUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $dados = $request->validated();

        $remember = $request->filled('remember');

        if (!Auth::attempt($dados, $remember)) {
            return back()
                ->withErrors(['general' => 'Credenciais inválidas.'])
                ->withInput();
        }

        return redirect()->route('inicio');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login.index');
    }

    public function loginOld(LoginOldUserRequest $request): JsonResponse
    {
        try {
            $dados = $request->validated();

            if (!Auth::attempt($dados)) {
                throw new \Exception('Email ou senha inválidos');
            }

            return response()->json([
                'message' => 'Usuário logado com sucesso!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    public function showForgotPasswordForm()
    {
        return view('users.forgot-password');
    }
    
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
    
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('success', 'Link de redefinição de senha enviado com sucesso!');
        }
    
        return back()->withErrors(['email' => 'Não conseguimos encontrar um usuário com esse e-mail.']);
    }


}
