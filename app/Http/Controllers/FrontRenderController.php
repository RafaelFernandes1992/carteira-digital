<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontRenderController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginV2()
    {
        return view('login2');
    }
}
