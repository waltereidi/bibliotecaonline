<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Livros;
class PerfilUsuarioController extends Controller
{
    private $livrosModel ;
    public function __construct()
    {
        $this->livrosModel = New Livros();
    }
    public function getPerfilUsuarioLivros($token_aplicacao , $users_id , $offset) :JsonResponse
    {
        $retorno = $this->livrosModel->getPerfilUsuarioLivros($users_id , $offset);

        if($retorno === null )
        {
            return response()->json('Nenhum resultado encontrado' , 204 );
        }
        if( count($retorno) > 0 )
        {
            return response()->json($retorno , 200 );
        }else{
            return response()->json($retorno , 500 );
        }


    }
}
