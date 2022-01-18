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
Route::get('/cadastrosBasicos', [App\Http\Controllers\HomeController::class, 'cadastroBasicos'])->name('cadastroBasicos');
//Documentos
Route::get('/documentos/cadastro', [App\Http\Controllers\DocumentosController::class, 'cadastroDoc'])->name('cadastroDoc');
Route::get('/documentos/cadastro/novo', [App\Http\Controllers\DocumentosController::class, 'novoDoc'])->name('novoDoc');
Route::post('/documentos/cadastro/novo', [App\Http\Controllers\DocumentosController::class, 'storeDoc'])->name('storeDoc');
Route::get('/documentos/cadastro/alterar/{id}', [App\Http\Controllers\DocumentosController::class, 'alterarDoc'])->name('alterarDoc');
Route::post('/documentos/cadastro/alterar/{id}', [App\Http\Controllers\DocumentosController::class, 'updateDoc'])->name('updateDoc');
Route::get('/documentos/cadastro/excluir/{id}', [App\Http\Controllers\DocumentosController::class, 'excluirDoc'])->name('excluirDoc');
Route::post('/documentos/cadastro/excluir/{id}', [App\Http\Controllers\DocumentosController::class, 'destroyDoc'])->name('destroyDoc');
Route::get('pesquisarDocumento', [App\Http\Controllers\DocumentosController::class, 'pesquisarDocumento'])->name('pesquisarDocumento');
Route::post('pesquisarDocumento', [App\Http\Controllers\DocumentosController::class, 'pesqDocumento'])->name('pesqDocumento');
Route::get('pesquisarDocumento/checkar/{id}', [App\Http\Controllers\DocumentosController::class, 'checkDoc'])->name('checkDoc');
//Fluxos
Route::get('escolher_unidades', [App\Http\Controllers\HomeController::class, 'escolher_unidade'])->name('escolher_unidade');
Route::get('fluxo/{id}', [App\Http\Controllers\HomeController::class, 'fluxo'])->name('fluxo');
Route::post('fluxo/{id}', [App\Http\Controllers\HomeController::class, 'storeFluxo'])->name('storeFluxo');
Route::get('validarFluxo/{id}', [App\Http\Controllers\HomeController::class, 'validar_fluxo'])->name('validar_fluxo');
Route::post('validarFluxo/{id}', [App\Http\Controllers\HomeController::class, 'storeValidar_fluxo'])->name('storeValidar_fluxo');
Route::get('nvalidarFluxo/{id}', [App\Http\Controllers\HomeController::class, 'validar_nfluxo'])->name('validar_nfluxo');
Route::post('nvalidarFluxo/{id}', [App\Http\Controllers\HomeController::class, 'storenValidar_fluxo'])->name('storenValidar_fluxo');
Route::get('validarDocs', [App\Http\Controllers\HomeController::class, 'validarDocs'])->name('validarDocs');
Route::post('validarDocs', [App\Http\Controllers\HomeController::class, 'validarDocumentos'])->name('validarDocumentos');
Route::get('visualizarFluxos', [App\Http\Controllers\HomeController::class, 'visualizarFluxos'])->name('visualizarFluxos');
//Unidades
Route::get('unidades/cadastro', [App\Http\Controllers\UnidadesController::class, 'cadastroUnd'])->name('cadastroUnd');
Route::get('unidades/cadastro/novo', [App\Http\Controllers\UnidadesController::class, 'novaUnd'])->name('novaUnd');
Route::post('unidades/cadastro/novo', [App\Http\Controllers\UnidadesController::class, 'storeUnd'])->name('storeUnd');
Route::get('unidades/cadastro/alterar/{id}', [App\Http\Controllers\UnidadesController::class, 'alterarUnd'])->name('alterarUnd');
Route::post('unidades/cadastro/alterar/{id}', [App\Http\Controllers\UnidadesController::class, 'updateUnd'])->name('updateUnd');
Route::get('unidades/cadastro/excluir/{id}', [App\Http\Controllers\UnidadesController::class, 'excluirUnd'])->name('excluirUnd');
Route::post('unidades/cadastro/excluir/{id}', [App\Http\Controllers\UnidadesController::class, 'deleteUnd'])->name('deleteUnd');
//Fornecedores
Route::get('fornecedores/cadastro', [App\Http\Controllers\FornecedoresController::class, 'cadastroForn'])->name('cadastroForn');
Route::get('fornecedores/cadastro/novo', [App\Http\Controllers\FornecedoresController::class, 'novoForn'])->name('novoForn');
Route::post('fornecedores/cadastro/novo', [App\Http\Controllers\FornecedoresController::class, 'storeForn'])->name('storeForn');
Route::get('fornecedores/cadastro/alterar/{id}', [App\Http\Controllers\FornecedoresController::class, 'alterarForn'])->name('alterarForn');
Route::post('fornecedores/cadastro/alterar/{id}', [App\Http\Controllers\FornecedoresController::class, 'updateForn'])->name('updateForn');
Route::get('fornecedores/cadastro/excluir/{id}', [App\Http\Controllers\FornecedoresController::class, 'excluirForn'])->name('excluirForn');
Route::post('fornecedores/cadastro/excluir/{id}', [App\Http\Controllers\FornecedoresController::class, 'deleteForn'])->name('deleteForn');
//Gestores
Route::get('gestores/cadastro', [App\Http\Controllers\GestorController::class, 'cadastroGest'])->name('cadastroGest');
Route::post('gestores/cadastro', [App\Http\Controllers\GestorController::class, 'pesquisarGestor'])->name('pesquisarGestor');
Route::get('gestores/cadastro/novo', [App\Http\Controllers\GestorController::class, 'novoGest'])->name('novoGest');
Route::post('gestores/cadastro/novo', [App\Http\Controllers\GestorController::class, 'storeGest'])->name('storeGest');
Route::get('gestores/cadastro/alterar/{id}', [App\Http\Controllers\GestorController::class, 'alterarGest'])->name('alterarGest');
Route::post('gestores/cadastro/alterar/{id}', [App\Http\Controllers\GestorController::class, 'updateGest'])->name('updateGest');
Route::get('gestores/cadastro/excluir/{id}', [App\Http\Controllers\GestorController::class, 'excluirGest'])->name('excluirGest');
Route::post('gestores/cadastro/excluir/{id}', [App\Http\Controllers\GestorController::class, 'deleteGest'])->name('deleteGest');
//Usuários
Route::get('users/cadastro', [App\Http\Controllers\UserController::class, 'cadastroUsuario'])->name('cadastroUsuario');
Route::post('users/cadastro', [App\Http\Controllers\UserController::class, 'pesquisarUsuario'])->name('pesquisarUsuario');
Route::get('users/cadastro/novo', [App\Http\Controllers\UserController::class, 'cadastroUsuarioNovo'])->name('cadastroUsuarioNovo');
Route::post('users/cadastro/novo', [App\Http\Controllers\UserController::class, 'store'])->name('store');
Route::get('users/cadastro/alterar/{id}', [App\Http\Controllers\UserController::class, 'cadastroUsuarioAlterar'])->name('cadastroUsuarioAlterar');
Route::post('users/cadastro/alterar/{id}', [App\Http\Controllers\UserController::class, 'alterarUsuario'])->name('alterarUsuario');
Route::get('users/cadastro/alterar/{id}/alterarSenha', [App\Http\Controllers\UserController::class, 'alterarSenhaUsuario'])->name('alterarSenhaUsuario');
Route::post('users/cadastro/alterar/{id}/alterarSenha', [App\Http\Controllers\UserController::class, 'updateSenha'])->name('updateSenha');
Route::get('users/cadastro/excluir/{id}', [App\Http\Controllers\UserController::class, 'cadastroUsuarioExcluir'])->name('cadastroUsuarioExcluir');
Route::post('users/cadastro/excluir/{id}', [App\Http\Controllers\UserController::class, 'deleteUsuario'])->name('deleteUsuario');
//Funções
Route::get('funcoes/cadastro', [App\Http\Controllers\FuncaoController::class, 'cadastroFuncoes'])->name('cadastroFuncoes');
Route::get('funcoes/cadastro/novo', [App\Http\Controllers\FuncaoController::class, 'novoFuncoes'])->name('novoFuncoes');
Route::post('funcoes/cadastro/novo', [App\Http\Controllers\FuncaoController::class, 'storeFuncoes'])->name('storeFuncoes');
Route::get('funcoes/cadastro/alterar/{id}', [App\Http\Controllers\FuncaoController::class, 'alterarFuncoes'])->name('alterarFuncoes');
Route::post('funcoes/cadastro/alterar/{id}', [App\Http\Controllers\FuncaoController::class, 'updateFuncoes'])->name('updateFuncoes');
Route::get('funcoes/cadastro/excluir/{id}', [App\Http\Controllers\FuncaoController::class, 'excluirFuncoes'])->name('excluirFuncoes');
Route::post('funcoes/cadastro/excluir/{id}', [App\Http\Controllers\FuncaoController::class, 'deleteFuncoes'])->name('deleteFuncoes');
//Cargos
Route::get('cargos/cadastro', [App\Http\Controllers\CargosController::class, 'cadastroCarg'])->name('cadastroCarg');
Route::get('cargos/cadastro/novo', [App\Http\Controllers\CargosController::class, 'novoCarg'])->name('novoCarg');
Route::post('cargos/cadastro/novo', [App\Http\Controllers\CargosController::class, 'storeCarg'])->name('storeCarg');
Route::get('cargos/cadastro/alterar/{id}', [App\Http\Controllers\CargosController::class, 'alterarCarg'])->name('alterarCarg');
Route::post('cargos/cadastro/alterar/{id}', [App\Http\Controllers\CargosController::class, 'updateCarg'])->name('updateCarg');
Route::get('cargos/cadastro/excluir/{id}', [App\Http\Controllers\CargosController::class, 'excluirCarg'])->name('excluirCarg');
Route::post('cargos/cadastro/excluir/{id}', [App\Http\Controllers\CargosController::class, 'deleteCarg'])->name('deleteCarg');
//PDF
Route::get('/PdfDemo', [App\Http\Controllers\PdfDemoController::class, 'index'])->name('index');
Route::get('/sample-pdf', [App\Http\Controllers\PdfDemoController::class, 'SamplePDF'])->name('SamplePDF');
Route::get('/save-pdf', [App\Http\Controllers\PdfDemoController::class, 'SavePDF'])->name('SavePDF');
Route::get('/download-pdf', [App\Http\Controllers\PdfDemoController::class, 'DownloadPDF'])->name('DownloadPDF');
Route::get('/html-to-pdf', [App\Http\Controllers\PdfDemoController::class, 'HtmlToPDF'])->name('HtmlToPDF');
Route::get('/pdf_cadastro', [App\Http\Controllers\PdfDemoController::class, 'HtmlToPDF_cadastro'])->name('HtmlToPDF_cadastro');
Route::post('/pdf_cadastro', [App\Http\Controllers\PdfDemoController::class, 'cadastrarPDF'])->name('cadastrarPDF');