<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Paginainicial\PostBuscaIndiceRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaginaInicialController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('paginainicial');
    }
    public function buscaIndice(PostBuscaIndiceRequest $request ) : JsonResponse
    {
        return response()->json('ok' , 204);
    }
}
