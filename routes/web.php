<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/auth/register', [App\Http\Controllers\UserController::class, 'telaRegistro'])->name('telaRegistro');
Route::post('auth/register', [App\Http\Controllers\UserController::class, 'store'])->name('store');
Route::get('password/email', [App\Http\Controllers\UserController::class, 'telaEmail'])->name('telaEmail');
Route::post('password/email', [App\Http\Controllers\UserController::class, 'emailReset'])->name('emailReset');
Route::get('resetar', [App\Http\Controllers\UserController::class, 'telaReset'])->name('telaReset');
Route::post('auth/passwords/reset', [App\Http\Controllers\UserController::class, 'resetarSenha'])->name('resetarSenha');
Route::post('auth/login', 'UserController@Login')->name('Login');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/documentos/cadastro', [App\Http\Controllers\DocumentosController::class, 'cadastroDoc'])->name('cadastroDoc');
Route::get('/documentos/cadastro/novo', [App\Http\Controllers\DocumentosController::class, 'novoDoc'])->name('novoDoc');
Route::post('/documentos/cadastro/novo', [App\Http\Controllers\DocumentosController::class, 'storeDoc'])->name('storeDoc');
Route::get('/documentos/cadastro/alterar/{id}', [App\Http\Controllers\DocumentosController::class, 'alterarDoc'])->name('alterarDoc');
Route::get('/documentos/cadastro/excluir/{id}', [App\Http\Controllers\DocumentosController::class, 'excluirDoc'])->name('excluirDoc');
Route::get('pesquisarDocumento', [App\Http\Controllers\DocumentosController::class, 'pesquisarDocumento'])->name('pesquisarDocumento');
Route::post('pesquisarDocumento', [App\Http\Controllers\DocumentosController::class, 'pesqDocumento'])->name('pesqDocumento');
Route::get('pesquisarDocumento/checkar/{id}', [App\Http\Controllers\DocumentosController::class, 'checkDoc'])->name('checkDoc');

Route::get('escolher_unidades', [App\Http\Controllers\HomeController::class, 'escolher_unidade'])->name('escolher_unidade');
Route::get('fluxo/{id}', [App\Http\Controllers\HomeController::class, 'fluxo'])->name('fluxo');
Route::post('fluxo/{id}', [App\Http\Controllers\HomeController::class, 'storeFluxo'])->name('storeFluxo');
Route::get('validarFluxo/{id}', [App\Http\Controllers\HomeController::class, 'validar_fluxo'])->name('validar_fluxo');
Route::post('validarFluxo/{id}', [App\Http\Controllers\HomeController::class, 'storeValidar_fluxo'])->name('storeValidar_fluxo');
Route::get('validarDocs/{id}', [App\Http\Controllers\HomeController::class, 'validarDocs'])->name('validarDocs');
