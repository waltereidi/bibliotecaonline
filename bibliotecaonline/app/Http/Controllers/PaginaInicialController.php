<?php

namespace App\Http\Controllers;
use App\Models\Livros;
use App\Http\Controllers\Controller;
use App\Http\Requests\Paginainicial\PostBuscaIndiceRequest;
use App\Http\Requests\Paginainicial\PostBuscaRequest;
use Illuminate\Http\JsonResponse;
use App\Models\Aplicativo;
class PaginaInicialController extends Controller
{
    private $livros ;
    public function __construct(){
        $this->livros = new Livros ;
    }

    public function index()
    {
        $token_aplicativo = Aplicativo::where('nome' ,'=' ,'bibliotecaonline')->select('token_aplicacao')->first();
        return view('paginainicial' )->with('token_aplicativo' , $token_aplicativo->token_aplicacao);

    }
    public function postBuscaIndice(PostBuscaIndiceRequest $request ) : JsonResponse
    {
        $dados = $request->all();

        $retorno = $this->livros->postBuscaIndice($dados['quantidade'] , $dados['iniciopagina'] , $dados['busca']);
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

        $retorno = $this->livros->postBusca($dados['busca']);
        if($retorno['quantidadeTotal'] == 0){
            return response()->json ('Busca sem resultados.' , 204);
        }
        else
        {
            return response()->json($retorno , 200 );
        }
    }

    public function getIndices() : JsonResponse
    {
        $retorno =$this->livros->getIndices() ;
        return response()->json($retorno, 200);
    }
}
