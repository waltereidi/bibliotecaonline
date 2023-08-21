<?php

use App\Http\Controllers\MensagensController;
use App\Http\Controllers\MeuPerfilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::prefix('meuperfil')->group(function () {
    Route::middleware('validartoken')->post('getPaginacaoLivrosDoUsuario', [MeuPerfilController::class, 'getPaginacaoLivrosDoUsuario']);
    Route::middleware('validartoken')->post('adicionarLivros', [MeuPerfilController::class, 'adicionarLivros']);
    Route::middleware('validartoken')->put('editarLivros', [MeuPerfilController::class, 'editarLivros']);
    Route::middleware('validartoken')->delete('removerLivros', [MeuPerfilController::class, 'removerLivros']);
    Route::middleware('validartoken')->put('editarMeuPerfil', [MeuPerfilController::class, 'editarMeuPerfil']);
    Route::middleware('validartoken')->post('getDadosMeuPerfil', [MeuPerfilController::class, 'getDadosMeuPerfil']);
});

Route::prefix('mensagens')->group(function () {
    Route::middleware('validartoken')->post('adicionarMensagens', [MensagensController::class, 'adicionarMensagens']);
    Route::middleware('validartoken')->delete('deletarMensagens', [MensagensController::class, 'deletarMensagens']);
    Route::middleware('validartoken')->put('editarMensagens', [MensagensController::class, 'editarMensagens']);
    Route::middleware('validartoken')->put('editarMensagensVisualizado', [MensagensController::class, 'editarMensagensVisualizado']);
    Route::middleware('validartoken')->post('getMensagensCaixa', [MensagensController::class, 'getMensagensCaixa']);
    Route::middleware('validartoken')->post('getMensagensLivros', [MensagensController::class, 'getMensagensLivros']);
});
Route::prefix('users')->group(function () {
    Route::post('getDadosUsers', [UsersController::class, 'getDadosUsers']);
});
