<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Livros;
use App\Models\MeuPerfil;

class MeuPerfilController extends Controller
{
    public $users_id ; 
    
    public function __construc(){
        $this->users_id = Auth::id();
        
    }
    public function setUsersId($id){
        $this->users_id = $id ;
    }
 
    public function index(){
        $livrosModel = new Livros; 
        if($this->users_id === null && Auth::id() === null) return view('auth.login');
                
            (Auth::id() === null) ? $this->setUsersId(Auth::id() ) : null ;
            $dataSourcePerfil = MeuPerfil::where('users_id',$this->users_id )->first();
            
            $dataSourceLivros = $livrosModel->meuPerfilLivrosDoUsuario($this->users_id);
            $dataSourceQuantidadeLivros = $livrosModel->meuPerfilLivrosDoUsuarioQuantidade($this->users_id);

            return view('meuperfil' , ['dataSourceLivros' => $dataSourceLivros,
                                'dataSourceUsers' => $dataSourcePerfil  , 
                                'dataSourceQuantidadeLivros' => $dataSourceQuantidadeLivros ]);
    }
    public function validarLivrosRequest(Request $livros) {
        $regras = [
            'users_id' => 'required',
            'titulo' => 'required|string|max:60',
            'descricao' => 'nullable|string|max:1024' , 
            'visibilidade' => 'required|integer' , 
            'isbn' => 'nullable|string|max:20' ,
            'editoras_nome' => 'required|string|max:60' ,
            'autores_nome' => 'required|string|max:60' , 
            'capalivro' => 'nullable|max:512|url'
        ];
        

        $mensagems= [
            'required' => 'Este campo é obrigatório' , 
            'max' => 'Limite de caracteres excedido' , 
            'url' => 'URL inválida'
        ];
        $dados =[ 
            'users_id' => $this->users_id ,
            'titulo' => $livros['titulo'] , 
            'descricao' => $livros['descricao'] , 
            'visibilidade' => $livros['visibilidade'] , 
            'isbn' => $livros['isbn'] , 
            'editoras_nome' => $livros['editoras_nome'] , 
            'autores_nome' => $livros['autores_nome'] , 
            'capalivro' => $livros['capalivro']
        ];
        if(isset($livros['id']) ){ 
            $regras['id'] = 'required' ;
            $dados['id'] = $livros['id'] ; 
        }

        return [ 'validador' => Validator::make( $dados , $regras , $mensagems) , 'dados'=>$dados ];
    } 
    public function validarMeuPerfilRequest(Request $meuPerfil ) {
        $regras = [
            'profile_picture' => 'url|string|max:1024', 
            'introducao' => 'string|max:1024' , 
            'users_id' => 'required|integer' , 
        ];
        $mensagens = [
            'url' => 'URL inválida' ,
            'required' => 'Este campo é obrigatório',
        ];
        $dados = [
            'users_id' => $this->users_id, 
            'profile_picture' => $meuPerfil->profile_picture , 
            'introducao' => $meuPerfil->introducao , 
        ];  

        return ['validador' => Validator::make($dados , $regras , $mensagens) , 'dados' =>$dados ];
    }

    public function adicionarLivros(Request $livros) { 
        $livrosModel = new Livros; 
        if($this->users_id === null && Auth::id() === null) return response()->json(['erro' => 'Nao autenticado' ] , 401 );

        $validaLivrosRequrest = $this->validarLivrosRequest($livros) ;
        $validar = $validaLivrosRequrest['validador'];
        $dados = $validaLivrosRequrest['dados'];
         
        if($validar->fails() ){
            return response()->json($validar->errors() , 419 );
        }else
        {
            
            $livro = $livrosModel->adicionarLivros($dados);
            return $livro ; 
        }
    }

    public function editarLivros(Request $livros)  {
        $livrosModel = new Livros; 
        if($this->users_id === null && Auth::id() === null) return response()->json(['erro' => 'Nao autenticado' ] , 401 );

        $validaLivrosRequrest = $this->validarLivrosRequest($livros);
        $validar = $validaLivrosRequrest['validador'];
        $dados = $validaLivrosRequrest['dados'];

        if($validar->fails() ){
            return response()->json($validar->errors() , 419 );
        }else
        {
            $livro = $livrosModel->editarLivros($dados);
            return $livro ; 
        }
    }

    public function removerLivros($id) : Bool {
        $livrosModel = new Livros; 
        $livro = $livrosModel->find($id); 
        if($livro){
            return $livro->delete();
        }else{
            return false ; 
        }
    }
    public function getPaginacaoLivrosDoUsuario(Request $request){
        $livros = new Livros; 
        return $livros->meuPerfilLivrosDoUsuario($request->users_id , $request->paginacao );

    }
    public function editarMeuPerfil(Request $request ){

        $validator = $this->validarMeuPerfilRequest($request);
        $dados = $validator['dados'];
        $validador = $validator['validador'];

        if($validador->fails()){
            return response()->json($validador->errors() , 419 );
        }else{
            $meuPerfil = new MeuPerfil();
            return $meuPerfil->editarMeuPerfil($dados);
        }

    }

}
