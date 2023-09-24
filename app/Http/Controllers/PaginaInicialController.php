<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Paginainicial\PostBuscaIndiceRequest;
use App\Http\Requests\Paginainicial\PostBuscaRequest;
use Illuminate\Http\JsonResponse;

class PaginaInicialController extends Controller
{

    public function index()
    {
        return view('paginainicial');
    }
    public function postBuscaIndice(PostBuscaIndiceRequest $request ) : JsonResponse
    {
        return response()->json('ok' , 204);
    }

    public function postBusca(PostBuscaRequest $request ) : JsonResponse
    {
        return response()->json ('ok' , 204);
    }
}
