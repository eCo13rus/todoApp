<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user(); // Получаем текущего пользователя
        return view('profile_edit.profile_edit', compact('user')); // Передаём его в шаблон
    }


    public function show()
    {
        $user = Auth::user();
        return view('profile_show.profile_show', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $customMessages = [
            'current_password.required' => 'Текущий пароль обязателен.',
            'new_password.min' => 'Пароль должен быть не менее 6 символов.',
            'new_password.confirmed' => 'Пароли не совпадают.',
        ];

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'nullable|string|min:6|confirmed',
        ], $customMessages);

        if (!$request->filled('new_password')) {
            session()->flash('current_password_correct', 'Текущий пароль введен верно. Введите новый пароль для обновления профиля.');
            return redirect()->back();
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Неверный текущий пароль']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Пароль успешно обновлен.');
    }
}
