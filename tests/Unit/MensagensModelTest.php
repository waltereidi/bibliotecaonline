<?php

namespace Tests\Unit;

use App\Models\Mensagens;
use App\Models\MeuPerfil;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Livros; 

class MensagensModelTest extends TestCase
{
 


    public function testeAdicionarMensagens_RetornaInstanciaDeMensagens() : void { 
        //Setup 
        $mensagens = new Mensagens; 
        $user = User::where('email' , '=' , 'testCase@email.com')->first(); 
        $meuPerfil = MeuPerfil::where( 'id' , '=' , $user->id )->first();
        Auth::loginUsingId($user->id); 
        $livros=  new Livros;    

        $livro = Livros::where('users_id' , '=' , $user->id )->first(); 
        $dados = [ 'meuperfil_id' => $meuPerfil->id , 
        'mensagem' => 'ModelTestCase AdicionarMensagem' , 
        'livros_id' => $livro->id ];     
        //Execução 

        $retornoAdicionarMensagens = $mensagens->adicionarMensagens($dados ); 
        //Assert 
        
        $this->assertInstanceOf(Mensagens::class , $retornoAdicionarMensagens);         
    }

    public function testeDeletarMensagens_RetornaTrue() : void { 
        //Setup 
        $mensagens = new Mensagens; 
        $user = User::where('email' , '=' , 'testCase@email.com')->first(); 
        $meuPerfil = MeuPerfil::where( 'id' , '=' , $user->id )->first();
        Auth::loginUsingId($user->id); 
        $livros=  new Livros;  

        $livro = Livros::where('users_id' , '=' , $user->id )->first() ; 
        $dados = [ 'meuperfil_id' => $meuPerfil->id , 
        'mensagem' => 'ModelTestCase AdicionarMensagem' , 
        'livros_id' => $livro->id ];     
        $retornoAdicionarMensagens = $mensagens->adicionarMensagens($dados ); 

        //Execução 
        $retornoDeletarMensagens = $mensagens->deletarMensagens($livro->id); 

        //Assert 
        $this->assertTrue($retornoDeletarMensagens) ; 
        
    }
    public function testeEditarMensagens_RetornaInstanciaDeMensagens() : void {
        //Setup 
        $mensagens = new Mensagens; 
        $user = User::where('email' , '=' , 'testCase@email.com')->first(); 
        $meuPerfil = MeuPerfil::where( 'id' , '=' , $user->id )->first();
        Auth::loginUsingId($user->id); 
        $livros=  new Livros;  

        $livro = Livros::where('users_id' , '=' , $user->id )->first() ; 
        $dados = [ 'meuperfil_id' => $meuPerfil->id , 
        'mensagem' => 'ModelTestCase AdicionarMensagem' , 
        'livros_id' => $livro->id ];     
        $retornoAdicionarMensagens = $mensagens->adicionarMensagens($dados ); 

        $dadosEditarMensagens = [
            'id' => $retornoAdicionarMensagens-> id , 
            'meuperfil_id' => $meuPerfil->id , 
            'mensagem' => 'ModelTestCase EditarMensagens'  ,
        ];
        //Execução 
        $retornoEditarMensagens = $mensagens->editarMensagens($dadosEditarMensagens);
        //Assert 
        $this->assertInstanceOf(Mensagens::class , $retornoEditarMensagens );

    }

    public function testeEditarMensagensVisualizado_RetornaBoolean() : void { 
        //Setup 
        $mensagens = new Mensagens; 
        $user = User::where('email' , '=' , 'testCase@email.com')->first(); 
        $meuPerfil = MeuPerfil::where( 'id' , '=' , $user->id )->first();
        Auth::loginUsingId($user->id); 
        $livros=  new Livros;  
        
        $livro = Livros::where('users_id' , '=' , $user->id )->first() ; 
        $meuPerfilLivro = MeuPerfil::where('users_id' , '=' , $livro->users_id)->first() ;
        $dados = [ 
            'livros_id' => $livro->id , 
            'meuperfil_id' => $meuPerfilLivro->id ,
            'sessao_meuperfil_id' => $meuPerfil->id 
        ] ;

        //Execução 
        $mensagensEditarVisualizado =  $mensagens->editarMensagensVisualizado($dados ); 

        //Assert 
        $this->assertIsBool($mensagensEditarVisualizado);
    }
 }


