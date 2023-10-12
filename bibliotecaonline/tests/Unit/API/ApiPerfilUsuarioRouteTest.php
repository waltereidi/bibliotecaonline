<?php

namespace Tests\Unit\API;

use App\Models\Aplicativo;
use App\Models\User;
use Tests\TestCase;


class ApiPerfilUsuarioRouteTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    private $url ;
    private $aplicativo ;
    private $user ;

    public function SetUp() : void
    {
        parent::SetUp();
        $this->aplicativo = Aplicativo::where('nome' ,'=' ,'bibliotecaonline')->first();
        $this->user = User::where('email' , '=' ,'testCase@email.com')->first();
        $this->url ='/api/perfilusuario/getPerfilUsuarioLivros/Bearer '.$this->aplicativo->token_aplicacao.'/'.$this->user->id.'/0';

    }
    public function testGetPerfilUsuarioLivros_SemToken_Retorna401(): void
    {
        //Setup
        $url ='/api/perfilusuario/getPerfilUsuarioLivros/Bearer /'.$this->user->id.'/0';
        //Execução
        $retorno = $this->get($url);

        //Assert
        $this->assertEquals($retorno->getStatusCode() , 401 );
    }

}
