<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class ApiMeuPerfilRoutesTest extends TestCase
{
    public $user ;

    public function setUp():void
    {
        parent::setUp();
        $this->user = User::where('email', '=', 'testCase@email.com')->first();
    }

    public function testeGetPaginacaoLivrosDoUsuario_SemToken_Retorna401(): void
    {

        $dados = ['paginacao' => 0, 'users_id' => $this->user->id];
        //Setup

        $retorno = $this->post('/api/meuperfil/getPaginacaoLivrosDoUsuario',  $dados);

        //Assert
        $retorno->assertStatus(401);
    }

    public function testeAdicionarLivros_SemToken_Retorna401(): void
    {
        //Setup
        $dados = ['Authorization' => 'Bearer Token'];
        //Execução
        $retorno = $this->post('/api/meuperfil/adicionarLivros',  $dados);

        //Assert
        $retorno->assertStatus(401);
    }



    public function testeEditarLivros_SemToken_Retorna401(): void
    {
        //Setup
        $dados = ['Authorization' => 'Bearer Token'];
        //Execução
        $retorno = $this->put('/api/meuperfil/editarLivros',  $dados);

        //Assert
        $retorno->assertStatus(401);
    }

    public function testeRemoverLivros_SemToken_Retorna401(): void
    {
        //Setup
        $dados = ['Authorization' => 'Bearer Token'];
        //Execução
        $retorno = $this->delete('/api/meuperfil/removerLivros', $dados);
        //Assert
        $retorno->assertStatus(401);
    }
    public function testeEditarMeuperfil_SemToken_Retorna401(): void
    {
        //Setup
        $dados = ['Authorization' =>     'Bearer Token'];
        //Execução
        $retorno = $this->put('/api/meuperfil/editarMeuPerfil',  $dados);

        //Assert
        $retorno->assertStatus(401);
    }

    public function testeGetDadosMeuPerfil_SemToken_Retorna401(): void
    {
        //Setup
        $dados = ['Authorization' => 'Bearer Token'];
        //Execução
        $retorno = $this->post('/api/meuperfil/getDadosMeuPerfil', $dados);

        //Assert
        $retorno->assertStatus(401);
    }
    public function testGetMeuPerfilLivrosDoUsuarioQuantidade_SemToken_Retorna401() : void
    {
        //setup

        $url = '/api/meuperfil/getMeuPerfilLivrosDoUsuarioQuantidade/Bearer /0';
        //execucao
        $retorno = $this->get($url);
        //assert
        $retorno->assertStatus(401);
    }
public function testGetMeuPerfilLivrosDoUsuarioQuantidade_ComToken_Retorna200() : void
    {
        //setup

        $url = '/api/meuperfil/getMeuPerfilLivrosDoUsuarioQuantidade/Bearer '.$this->user->api_token.'/0';
        //execucao
        $retorno = $this->get($url);
        //assert
        $retorno->assertStatus(200);
    }
    public function testDeleteLivros_Retorna204() : void
    {
        //setup

        $url = '/api/meuperfil/deleteLivros/Bearer '.$this->user->api_token.'/0';
        //execucao
        $retorno = $this->delete($url);
        //assert
        $retorno->assertStatus(204);
    }
}
