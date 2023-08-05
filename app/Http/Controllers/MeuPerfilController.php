<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Livros; 
use App\Models\User;

class MeuPerfilController extends Controller
{
    public $users_id ; 
    
    public function __construc(){
        $this->users_id = Auth::id();
    }
    public function SetUsersId($id){
        $this->users_id = $id ;
    }
 
    public function index(){

        if($this->users_id === null && Auth::id() === null) return view('auth.login');
                
          
                (Auth::id() === null) ? $this->SetUsersId(Auth::id() ) : null ;
                $dataSourcePerfil = User::where('id' , $this->users_id )->first();
                $livros = new Livros;
                $dataSourceLivros = $livros->meuPerfilLivrosDoUsuario($this->users_id);

                return view('meuperfil' , ['dataSourceLivros' => $dataSourceLivros->count(0)==0 ? null : $dataSourceLivros ,
                                'dataSourceUsers' => $dataSourcePerfil ] );
    }
    
    public function adicionarLivros(Request $livros) { 
        
        if($this->users_id === null && Auth::id() === null) return response()->json(['erro' => 'Nao autenticado' ] , 401 );

        $regras = [
            'users_id' => 'required',
            'titulo' => 'required|string|max:60',
            'descricao' => 'nullable|string|max:1024' , 
            'visibilidade' => 'required|integer' , 
            'isbn' => 'nullable|string|max:20' ,
            'editoras_nome' => 'required|string|max:60' ,
            'autores_nome' => 'required|string|max:60' , 
        ];
        $mensagems= [
            'required' => 'Este campo é obrigatório' , 
            'max' => 'Limite de caracteres excedido' , 
        ];
        $dados =[ 
            'users_id' => $this->users_id ,
            'titulo' => $livros['titulo'] , 
            'descricao' => $livros['descricao'] , 
            'visibilidade' => $livros['visibilidade'] , 
            'isbn' => $livros['isbn'] , 
            'editoras_nome' => $livros['editoras_nome'] , 
            'autores_nome' => $livros['autores_nome']
        ];
        $validar = Validator::make( $dados , $regras , $mensagems);

        if($validar->fails() ){
            return response()->json($validar->errors() , 419 );
        }else
        {
            $livrosModel = new Livros;
            $livro = $livrosModel->adicionarLivros($dados);
            return $livro ; 
        }
    }

    public function editarLivros(Livros $livros) : Livros {
        $livros = Livros::getModel();
        return $livros ; 
    }


    public function removerLivros($id) : Bool {
        return true ; 

    }

}
