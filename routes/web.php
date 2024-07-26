<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserProfileController;

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

Route::middleware('guest')->group(function () {
    Route::get('login', function () {
        return view('login.index');
    })->name('login');

    Route::get('register', function () {
        return view('register.index');
    })->name('register');
});

Route::get('/', [TaskController::class, 'index'])->name('home');
Route::post('login', [LoginController::class, 'login'])->name('login');
Route::post('register', [RegisterController::class, 'register'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [UserProfileController::class, 'update'])->name('profile.update');
Route::resource('tasks', TaskController::class);

Route::post('/tasks/{task}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
