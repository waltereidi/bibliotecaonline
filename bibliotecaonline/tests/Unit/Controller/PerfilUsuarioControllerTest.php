<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\PerfilUsuarioController;
use App\Models\Aplicativo;
use App\Models\User;
use Tests\TestCase;
use Illuminate\View\View;
use App\Models\MeuPerfil ;


class PerfilUsuarioControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    private $perfilUsuarioController ;
    private $user ;
    private $aplicativo;
    public function SetUp():void
    {
        parent::SetUp() ;
        $this->perfilUsuarioController = new PerfilUsuarioController();
        $this->user = User::where('email' , '=' ,'testCase@email.com')->first();
        $this->aplicativo = Aplicativo::where('nome' , '=' ,'bibliotecaonline')->first();

    }
    public function testGetPerfilUsuarioLivros_VazioRetorna204(): void
    {
        //setup
        $token_aplicacao = $this->aplicativo->token_aplicacao;
        $users_id = 0 ;
        $offset = 0 ;
        //execucao
        $retorno = $this->perfilUsuarioController->getPerfilUsuarioLivros($token_aplicacao , $users_id , $offset );

        //assert
        $this->assertEquals($retorno->getStatusCode() , 204 );

    }
    public function testGetPerfilUsuarioLivros_ComDadosRetorna200() : void
    {
        //setup
        $token_aplicacao = $this->aplicativo->token_aplicacao;
        $users_id = $this->user->id ;
        $offset = 0 ;
        //execucao
        $retorno = $this->perfilUsuarioController->getPerfilUsuarioLivros($token_aplicacao , $users_id  , $offset );
        //assert

        $this->assertEquals($retorno->getStatusCode() , 200 ) ;
    }
    public function testGetMeuPerfil_RetornaViePaginainicialComToken(){
        //setup

        //execucao
        $view = $this->perfilUsuarioController->getMeuPerfil(0);
        $viewDataSource = $view->getData();

        //assert
        $this->assertInstanceOf(View::class , $view );
        $this->assertEquals('paginainicial' , $view->getName() );
        $this->assertEquals($viewDataSource['token_aplicativo'] ,$this->aplicativo->token_aplicacao);



    }
    public function testGetMeuPerfil_RetornaViewComLivro() :void
    {
        //setup
        $meuPerfil = MeuPerfil::first();

        //execucao
        $view = $this->perfilUsuarioController->getMeuPerfil($meuPerfil->id);
        $viewDataSource = $view->getData();
        //assert
        $this->assertInstanceOf(View::class , $view );
        $this->assertEquals('perfilusuario' , $view->getName() );
        $this->assertNotEmpty($viewDataSource['meuperfil']);
        $this->assertEquals($viewDataSource['meuperfil']->token_aplicativo , $this->aplicativo->token_aplicacao);

    }


}
