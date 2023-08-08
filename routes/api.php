<?php

use App\Http\Controllers\MeuPerfilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\VerificarCsrfApi;
use Illuminate\Contracts\Session\Session;

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

Route::post('meuperfil/adicionarLivros', [MeuPerfilController::class , 'adicionarLivros'] );

Route::post('meuperfil/getPaginacaoLivrosDoUsuario' , [MeuPerfilController::class , 'getPaginacaoLivrosDoUsuario']);

Route::put('meuperfil/editarLivros' , [MeuPerfilController::class , 'editarLivros']);

Route::delete('meuperfil/removerLivro/{id}/{crsf_token}');

Route::put('meuperfil/editarMeuPerfil' , [MeuPerfilController::class , 'editarMeuPerfil']);




