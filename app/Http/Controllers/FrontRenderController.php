<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontRenderController extends Controller
{
    public function login()
    {
        return view('login.index');
    }

    public function loginOld()
    {
        return view('login.login-old');
    }
}
