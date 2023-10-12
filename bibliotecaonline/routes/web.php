<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeuPerfilController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PaginaInicialController;
use App\Http\Controllers\LivrosController;
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

Route::get('/', [PaginaInicialController::class, 'index'])  ;

Auth::routes(['verify' => true]);

Route::get('/paginainicial', [PaginaInicialController::class, 'index'])->name('paginainicial');

Route::post('/meuPerfil', [MeuPerfilController::class, 'index'])->name('meuperfil');

Route::get('/livros/{id}',[LivrosController::class , 'getLivro' ]);
Route::get('/perfilusuario/{id}' , [MeuPerfilController::class , 'getMeuPerfil']);


