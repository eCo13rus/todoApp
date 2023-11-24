<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email обязателен для заполнения',
            'password.required' => 'Пароль обязателен для заполнения',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->withInput()->with('error', 'Неверное имя или пароль');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
