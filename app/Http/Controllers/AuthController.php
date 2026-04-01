<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt([
            'login' => $request->login,
            'password' => $request->senha
        ])) {

            $request->session()->regenerate();

            return redirect('/receitas');
        }

        return back()->with('erro', 'Login inválido');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}