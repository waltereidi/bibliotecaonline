<?php

use App\Http\Controllers\MeuPerfilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;

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
Route::get('enviarEmail' , function(){

    Mail::to('walter-eidi@hotmail.com')->send(new WelcomeEmail());
    return 'ok';
});

Route::post('meuperfil/adicionarLivros', [MeuPerfilController::class , 'adicionarLivros'] )->name('meuperfil/adicionarLivros');
Route::post('meuperfil/getPaginacaoLivrosDoUsuario' , [MeuPerfilController::class , 'getPaginacaoLivrosDoUsuario']);
Route::post('meuperfil/editarMeuPerfil' , [MeuPerfilController::class , 'editarMeuPerfil']);