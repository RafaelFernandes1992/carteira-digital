<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class PasswordController extends Controller
{
    // Método para exibir o formulário de esqueci a senha
    public function showForgotPasswordForm()
    {
        return view('users.forgot-password'); // Aqui você define a view
    }

    // Método para enviar o link de redefinição de senha
    public function sendResetLink(Request $request)
    {
        // Validação do email
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Enviar o link para redefinir a senha
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Se o link foi enviado com sucesso
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('success', 'Link de redefinição de senha enviado com sucesso!');
        }

        // Se algo deu errado
        return back()->withErrors(['email' => 'Não conseguimos encontrar um usuário com esse e-mail.']);
    }
}

