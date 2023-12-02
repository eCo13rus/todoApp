<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

        // Проверить, существует ли пользователь с таким email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withInput()->withErrors([
                'email' => 'Такого пользователя не существует.',
            ]);
        }

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            session()->flash('success','Здравствуйте ' . Auth::user()->name . ', вход успешно выполнен!');
            return redirect()->route('home');
        }


        return redirect()->back()->withInput()->withErrors([
            'email' => 'Неверное имя пользователя или пароль.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
