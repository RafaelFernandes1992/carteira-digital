<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $dados = $request->validated();

        if (!Auth::attempt($dados)) {
            return back()
                ->withErrors(['general' => 'Credenciais inválidas.'])
                ->withInput();
        }

        return redirect()->route('index.home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('index.login');
    }
}
