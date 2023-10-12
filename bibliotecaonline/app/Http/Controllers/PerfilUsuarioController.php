<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Livros;
use App\Models\MeuPerfil;
use App\Models\Aplicativo;
class PerfilUsuarioController extends Controller
{
    private $livrosModel ;
    private $meuPerfilModel ;
    private $aplicativo;
    public function __construct()
    {
        $this->livrosModel = New Livros();
        $this->meuPerfilModel = New MeuPerfil();
        $this->aplicativo = Aplicativo::where('nome' , '=' , 'bibliotecaonline')->first();

    }
    public function getMeuPerfil(int $id)
    {
        $perfilusuario = $this->meuPerfilModel->getMeuPerfil($id);

        if($perfilusuario){
            $perfilusuario->token_aplicativo = $this->aplicativo->token_aplicacao;
            return view('perfilusuario')->with('meuperfil' , $perfilusuario);
        }
        else{
            return view('paginainicial')->with('token_aplicativo' , $this->aplicativo->token_aplicacao );
        }



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
