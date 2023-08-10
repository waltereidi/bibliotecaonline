<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mensagens\DeleteMensagensRequest;
use App\Http\Requests\Mensagens\PostMensagensRequest;
use App\Http\Requests\Mensagens\PutMensagensRequest;
use App\Http\Requests\Mensagens\PutMensagensVisualizadoRequest;
use App\Models\Mensagens;
use App\Models\MeuPerfil;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MensagensController extends Controller
{
    protected $users_id ;
    protected $mensagens ;
    public function __construct(){
        $this->users_id = Auth::id(); 
        $this->mensagens = new Mensagens();
    }
    public function setUsersId($id){
        $this->users_id = $id ; 
    }

    public function adicionarMensagens( PostMensagensRequest $request ) : JsonResponse {
    
        $dados = $request->all() ; 
        $meuPerfil = MeuPerfil::where('users_id' , '=' , $this->users_id )->first();
        $dados['meuperfil_id'] = $meuPerfil->id ; 

        $retorno = $this->mensagens->adicionarMensagens($dados) ; 
        if($retorno === null ){
            response()->json('Erro no banco de dados , contate o admnistrador.' , 501);
        }else{
            return response()->json(  $retorno  , 200);

        }

    }
    public function deletarMensagens(DeleteMensagensRequest $request ) : JsonResponse {
        $retorno = $this->mensagens->deletarMensagens($request->id ); 
        
        return response()->json($retorno , 200 );
    }

    public function editarMensagens(PutMensagensRequest $request ) : JsonResponse { 
        $dados = $request->all() ; 
        $retorno = $this->mensagens->editarMensagens( $dados );
        if($retorno === null ){
            response()->json('Erro no banco de dados , contate o admnistrador.' , 501 );            
        }else{
            return response()->json($retorno , 200 ) ; 
        }
    }
    public function editarMensagensVisualizado(PutMensagensVisualizadoRequest $request ) : JsonResponse {

        $meuPerfil = MeuPerfil::where('users_id' , '=' , $this->users_id)->first(); 
        $dados = $request->all() ; 
        $dados['meuperfil_id'] = $meuPerfil->id ; 

        $retorno = $this->mensagens->editarMensagensVisualizado( $dados );
        if(!$retorno){
            return response()->json( 'Ocorreu um erro ao editar a visualização de sua mensagem , contate o administrador.' , 501 ) ;
        }else{
            return response()->json( true , 200 ); 
        }

    }

}
