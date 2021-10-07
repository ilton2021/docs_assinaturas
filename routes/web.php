<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/auth/register', [App\Http\Controllers\UserController::class, 'telaRegistro'])->name('telaRegistro');

Route::post('password/email', [App\Http\Controllers\UserController::class, 'emailReset'])->name('emailReset');

Route::get('password/reset', 'UserController@telaReset')->name('telaReset');
Route::post('auth/passwords/reset', 'UserController@resetarSenha')->name('resetarSenha');
Route::post('auth/login', 'UserController@Login')->name('Login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
