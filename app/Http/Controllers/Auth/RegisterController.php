<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $customMessages = [
            'name.required' => 'Имя обязательно для заполнения',
            'email.required' => 'Email обязателен для заполнения',
            'email.unique' => 'Такой email уже зарегистрирован.',
            'password.required' => 'Пароль обязателен для заполнения',
            'password' => 'Пароль должен быть не менее 6 символов.',
        ];

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], $customMessages);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        session()->flash('success', 'Здравствуйте ' . $user->name . ', вы успешно зарегистрировались.');

        return redirect()->route('home');
    }
}
