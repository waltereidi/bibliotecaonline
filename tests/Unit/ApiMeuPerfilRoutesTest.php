<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class ApiMeuPerfilRoutesTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function testeGetPaginacaoLivrosDoUsuario_SemToken_Retorna401(): void
    {
        $user = User::where('email', '=', 'testCase@email.com')->first();
        $dados = ['paginacao' => 0, 'users_id' => $user->id];
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
}
