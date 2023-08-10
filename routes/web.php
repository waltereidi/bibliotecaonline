<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeuPerfilController;
use App\Models\Livros;

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

Route::get('/', function () {
    return view('paginainicial');
});

Auth::routes(['verify' => true]);

Route::get('/paginainicial', [App\Http\Controllers\PaginaInicialController::class, 'index'])->name('paginainicial');

Route::post('/meuPerfil' ,[App\Http\Controllers\MeuPerfilController::class, 'index'] )->name('meuperfil');
