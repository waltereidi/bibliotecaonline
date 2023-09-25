<?php

namespace App\Http\Controllers;
use App\Models\Livros;
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
        $dados = $request->all();
        $livros = new Livros;

        $retorno = $livros->postBuscaIndice($dados['quantidade'] , $dados['iniciopagina'] , $dados['busca']);
        if($retorno['quantidadeTotal'] ==0 ){
            return response()->json('Busca sem resultados.' , 204);
        }
        else{
            return response()->json($retorno , 200);
        }


    }

    public function postBusca(PostBuscaRequest $request ) : JsonResponse
    {
        $dados = $request->all();
        $livros = new Livros ;
        $retorno = $livros->postBusca($dados['busca']);
        if($retorno['quantidadeTotal'] == 0){
            return response()->json ('Busca sem resultados.' , 204);
        }
        else
        {
            return response()->json($retorno , 200 );
        }
    }
}
