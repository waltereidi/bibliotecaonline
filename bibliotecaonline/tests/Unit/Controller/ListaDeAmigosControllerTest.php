<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\ListaDeAmigosController;
use App\Http\Requests\ListaDeAmigos\DeleteListaDeAmigosRequest;
use App\Http\Requests\ListaDeAmigos\PostListaDeAmigosRequest;
use App\Models\ListaDeAmigos;
use App\Models\Livros;
use App\Models\MeuPerfil;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ListaDeAmigosControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
   public $listaDeAmigosController ;
   public $user;
   public $meuPerfil ;
   public $livros ;
   public $livro ;
   public function setUp() : void {
        parent::setUp();

        $this->user = User::where('email' , '=' , 'testCase@email.com')->first();
        Auth::loginUsingId($this->user->id );
        $this->listaDeAmigosController = new ListaDeAmigosController();

        $this->meuPerfil = MeuPerfil::where('users_id' , '=' , $this->user->id )->first();
        $this->livros = new Livros();

        $this->livro = Livros::where('users_id' , '=' , $this->user->id)->first();
   }

   public function testeGetListaDeAmigos_RetornaDataSource() : void {
        //Setup

        //Execução
        $getListaDeAmigosDataSource =  $this->listaDeAmigosController->getListaDeAmigos( );

        //Assert
        $this->assertEquals(200 , $getListaDeAmigosDataSource->getStatusCode() ) ;

   }

   public function testeAdicionarListaDeAmigos_RetornaDataSource() : void {
          //Setup
          $userAmigo = User::where('email' ,'=' , 'testCaseAmigo@email.com')->first();

          $meuPerfilAmigo = MeuPerfil::where('users_id' , '=' , $userAmigo->id)->first();

          $requestAdiconarListaDeAmigos = new PostListaDeAmigosRequest([
               'meuperfil_id' => $meuPerfilAmigo->id  ,
               'livros_id' => $this->livro->id ,
               ]);

          //Execução
          $retornoAdicionaListaDeAmigos = $this->listaDeAmigosController->adicionarListaDeAmigos( $requestAdiconarListaDeAmigos );
          //Assert
          $this->assertEquals(200 , $retornoAdicionaListaDeAmigos->getStatusCode());


   }
   public function testeRemoverListaDeAmigos_RetornaBoolean() : void {


          //Setup
          $userAmigo = User::where('email' , '=' ,'testCaseAmigo@email.com')->first();
          $meuPerfilAmigo = MeuPerfil::where('users_id' , '=' , $userAmigo->id)->first();

          $listaDeAmigos = ListaDeAmigos::where('meuperfil_id' ,'=' , $this->meuPerfil->id )
          ->where('meuperfilamigo_id' , '=' , $meuPerfilAmigo->id )->first();

          $deleteListaDeAmigosRequest = new DeleteListaDeAmigosRequest(
               ['id' => $listaDeAmigos->id ,
               'meuperfil_id' => $listaDeAmigos->meuperfil_id ,
               'meuperfilamigo_id' => $listaDeAmigos->meuperfilamigo_id ,
               ]
          );
          //Execução
          $removerListaDeAmigos = $this->listaDeAmigosController->removerListaDeAmigos( $deleteListaDeAmigosRequest );

          //Assert
          $this->assertEquals(200 , $removerListaDeAmigos->getStatusCode());
   }




}
