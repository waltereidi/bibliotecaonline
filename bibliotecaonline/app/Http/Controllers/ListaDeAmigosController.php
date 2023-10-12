<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListaDeAmigos\DeleteListaDeAmigosRequest;
use App\Http\Requests\ListaDeAmigos\PostListaDeAmigosRequest;
use App\Models\ListaDeAmigos;
use App\Models\Livros;
use App\Models\MeuPerfil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListaDeAmigosController extends Controller
{
    //
    protected $meuPerfil ; 
    protected $listaDeAmigos ; 
    public function __construct()
    {
        $this->meuPerfil = MeuPerfil::where('users_id' ,'=' , Auth::id() )->first();         
        $this->listaDeAmigos = new ListaDeAmigos() ;
    }

    public function getListaDeAmigos( ) : JsonResponse {

        $dataSource = $this->listaDeAmigos->getListaDeAmigos(Auth::id());
        return response()->json($dataSource , 200 );

    }

    public function adicionarListaDeAmigos( PostListaDeAmigosRequest $request ) : JsonResponse{
        if($this->meuPerfil->id == $request->meuperfil_id){
            
            $dados['meuperfil_id']= $this->meuPerfil->id ; 
            $livro = Livros::find($request->livros_id)->first();
            $dados['meuperfilamigo_id']= MeuPerfil::where('users_id' , '=' , $livro->users_id)->first();
        }else{
            $dados['meuperfilamigo_id']= $request['meuperfil_id'] ; 
            $dados['meuperfil_id'] = $this->meuPerfil->id ;
        }

        $dataSource = $this->listaDeAmigos->adicionarListaDeAmigos( $dados );
        
        if(!$dataSource){
            return response()->json(false , 501 );
        }else{
            return response()->json($dataSource , 200) ;    
        }
    }
    public function removerListaDeAmigos(DeleteListaDeAmigosRequest $request ) : JsonResponse {

        $dados = $request->all();
        return response( )->json($this->listaDeAmigos->removerListaDeAmigos($dados) , 200);

    }


}
