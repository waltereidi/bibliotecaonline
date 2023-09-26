<?php

namespace Tests\Unit;

use App\Http\Controllers\UsersController;
use Tests\TestCase;
use App\Models\User;

class ApiUserRoutesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public $usersController;

    public function SetUp(): void
    {
        parent::SetUp();
        $usersController = new UsersController;
    }
    public function testeGetDadosUsuario_RetornaDadosUsuario(): void
    {
        //SetUp
        $user = User::where('email', '=', 'testCase@email.com')->first();
        $dados = ['email' => $user->email, 'password' => $user->password];
        //Execução
        $retorno = $this->post('/api/users/getDadosUsers', $dados);
        //dd($retorno);
        $usersDataSource = $retorno->getData();
        $validarChaves = get_object_vars($usersDataSource);

        //Assert
        $this->assertEquals(200, $retorno->getStatusCode());
        $this->assertNotEmpty($usersDataSource);
        $this->assertIsObject($usersDataSource);
        $this->assertArrayHasKey('id', $validarChaves);
        $this->assertArrayHasKey('name', $validarChaves);
        $this->assertArrayHasKey('email', $validarChaves);
        $this->assertArrayHasKey('email_verified_at', $validarChaves);
        $this->assertArrayHasKey('created_at', $validarChaves);
        $this->assertArrayHasKey('updated_at', $validarChaves);
        $this->assertArrayHasKey('api_token', $validarChaves);
        $this->assertArrayHasKey('validade_token', $validarChaves);
    }
    public function testeGetDadosUsuario_CredenciaisInvalida_Retorna402(): void
    {
        //Setup
        $dados = ['email' => 'email@email.com', 'password' => 'senha'];

        //Execução

        $retorno = $this->post('/api/users/getDadosUsers', $dados);

        //Assert
        $this->assertEquals(402, $retorno->getStatusCode());
    }
    public function testeGetDadosUsuario_DadosNaoPreenchidos_Retorna301(): void
    {
        //Setup
        $dados = ['email' => 'email', 'password' => null];

        //Execução

        $retorno = $this->post('api/users/getDadosUsers', $dados);

        //Assert
        $this->assertEquals(302, $retorno->getStatusCode());
        $retorno->assertSessionHasErrors(['email' => 'Email inválido']);
        $retorno->assertSessionHasErrors(['password' => 'Campo obrigatório não preenchido']);
    }
}
