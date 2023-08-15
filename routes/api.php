<?php

use App\Http\Controllers\MensagensController;
use App\Http\Controllers\MeuPerfilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

 
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('meuperfil')->group(function(){
    Route::middleware('validartoken:api')->post('getPaginacaoLivrosDoUsuario' , [MeuPerfilController::class , 'getPaginacaoLivrosDoUsuario']);
    Route::middleware('validartoken:api')->post('adicionarLivros', [MeuPerfilController::class , 'adicionarLivros'] );
    Route::middleware('validartoken:api')->put('editarLivros' , [MeuPerfilController::class , 'editarLivros']);
    Route::middleware('validartoken:api')->delete('removerLivros' , [MeuPerfilController::class , 'removerLivros']);
    Route::middleware('validartoken:api')->put('editarMeuPerfil' , [MeuPerfilController::class , 'editarMeuPerfil']);

});

Route::prefix('mensagens')->group( function(){
    Route::middleware('validartoken:api')->post('adicionarMensagens' , [MensagensController::class , 'adicionarMensagens']); 
    Route::middleware('validartoken:api')->delete('deletarMensagens' , [MensagensController::class , 'deletarMensagens']);
    Route::middleware('validartoken:api')->put('editarMensagens' , [MensagensController::class , 'editarMensagens']);
    Route::middleware('validartoken:api')->put('editarMensagensVisualizado' , [MensagensController::class , 'editarMensagensVisualizado']);
    Route::middleware('validartoken:api')->get('getMensagensCaixa' , [MensagensController::class , 'getMensagensCaixa']);
    Route::middleware('validartoken:api')->post('getMensagensLivros' , [MensagensController::class , 'getMensagensLivros']);
    
});




