<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mensagens\GetMensagensLivrosRequest;
use App\Http\Requests\Mensagens\DeleteMensagensRequest;
use App\Http\Requests\Mensagens\PostMensagensRequest;
use App\Http\Requests\Mensagens\PutMensagensRequest;
use App\Http\Requests\Mensagens\PutMensagensVisualizadoRequest;
use App\Models\Mensagens;
use App\Models\MeuPerfil;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Livros;
class MensagensController extends Controller
{
    protected $users_id ;
    protected $mensagens ;
    protected $meuPerfil ; 
    public function __construct(){
        $this->users_id = Auth::id(); 
        $this->mensagens = new Mensagens();
        $this->meuPerfil = MeuPerfil::where('users_id' , '=' , $this->users_id)->first(); 
    }
    public function setUsersId($id){
        $this->users_id = $id ; 
    }

    public function adicionarMensagens( PostMensagensRequest $request ) : JsonResponse {
    
        $dados = $request->all() ; 
        $dados['meuperfil_id'] = $this->meuPerfil->id ; 

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

        $dados = $request->all() ; 
        $dados['sessao_meuperfil_id'] = $this->meuPerfil->id ; 
        

        $retorno = $this->mensagens->editarMensagensVisualizado( $dados );
       
            return response()->json( true , 200 ); 

    }
    public function getMensagensCaixa( ) : JsonResponse {

        $retorno = $this->mensagens->getMensagensCaixa($this->meuPerfil->id );
        
            return response()->json($retorno , 200 ); 

    }
    public function getMensagensLivros( GetMensagensLivrosRequest $request ) : JsonResponse {
        
        if(Livros::find($request->livros_id )){
        $dados['livros_id'] = $request->livros_id ; 
        $dados['meuperfil_id'] = $this->meuPerfil->id ;
        $dados['users_id'] = $this->users_id; 
        $retorno = $this->mensagens->getMensagensLivros( $dados ); 

        return response()->json($retorno , 200 );
        }else{
            return response()->json('id não enviado' , 419);
        }
    }

}
