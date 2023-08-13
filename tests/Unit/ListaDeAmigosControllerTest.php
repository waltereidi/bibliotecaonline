<?php

namespace Tests\Unit;

use App\Http\Controllers\ListaDeAmigosController;
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

   public function setUp() : void {
        parent::setUp();
        $this->listaDeAmigosController = new ListaDeAmigosController();
        $this->user = User::where('email' , '=' , 'testCase@email.com')->first();
        $this->meuPerfil = MeuPerfil::where('users_id' , '=' , $this->user->id )->first();
        $this->livros = new Livros(); 
        Auth::loginUsingId($this->user->id ); 
   }

   public function TesteGetListaDeAmigos_RetornaDataSource() : void { 
        //Setup 

        //Execução 
        $getListaDeAmigosDataSource =  $this->listaDeAmigosController->getListaDeAmigos( ); 

        //Assert 
        $this->assertEquals(200 , $getListaDeAmigosDataSource->getStatusCode() ) ; 
        
   }

   public function TesteAdicionarListaDeAmigos_RetornaDataSource() : void { 



   }
   public function TesteRemoverListaDeAmigos_RetornaBoolean() : void { 


   }




}
