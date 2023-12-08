<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TaskController::class, 'index'])->name('home');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('login', [LoginController::class, 'login'])->name('login');

Route::post('register', [RegisterController::class, 'register'])->name('register');

Route::get('login', function () {
    return view('login.index');
})->name('login');

Route::get('register', function () {
    return view('register.index');
})->name('register');

Route::resource('tasks', TaskController::class);
