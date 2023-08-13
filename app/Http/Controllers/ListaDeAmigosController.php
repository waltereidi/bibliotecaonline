<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ListaDeAmigos;
use App\Models\MeuPerfil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListaDeAmigosController extends Controller
{
    //
    private $meuPerfil ; 
    private $ListaDeAmigos ; 
    public function __construct()
    {
        $this->meuPerfil = MeuPerfil::where('users_id' ,'=' , Auth::id() );         
        $this->ListaDeAmigos = new ListaDeAmigos() ;
    }

    public function getListaDeAmigos( ) : ?JsonResponse {

        $dataSource = $this->ListaDeAmigos->getListaDeAmigos(Auth::id());
        return response()->json($dataSource , 200 );

    }

    


}
