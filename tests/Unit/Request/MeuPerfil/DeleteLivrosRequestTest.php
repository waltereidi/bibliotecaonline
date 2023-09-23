<?php

namespace Tests\Unit\Request\MeuPerfil;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;

class DeleteLivrosRequestTest extends TestCase
{
    public $user;
    public $url;
    public $dados;
    public function SetUp(): void
    {
        parent::setUp();
        $this->user = User::where('email', '=', 'testCase@email.com')->first();
        Auth::loginUsingId($this->user->id);
        $this->url = '/api/meuperfil/deleteLivros';
        $this->dados = ['Authorization' => 'Bearer ' . $this->user->api_token];
    }

    public function testeDeleteLivros_SemToken_Retorna401()
    {
        //Setup
        $dados = [
            'Authorization' => 'Bearer ',
        ];
        //Execução
        $retorno = $this->delete($this->url, $dados);
        //Assert
        $this->assertEquals(401, $retorno->getStatusCode());
    }
    public function testeDeleteLivrosRequestRetorna204(): void
    {
        //Setup
        $dados = $this->dados;
        $dados['id'] = 0;

        //Execucao
        $retorno = $this->delete($this->url, $dados);

        //Assert
        $this->assertEquals(204, $retorno->getStatusCode());
    }
    public function testeDeleteLivrosRequestRetorna302(): void
    {
        //Setup
        $dados = $this->dados;

        //Execucao
        $retorno = $this->delete($this->url, $dados);

        //Assert
        $this->assertEquals(302, $retorno->getStatusCode());
        $retorno->assertSessionHasErrors(['id' => 'Campo obrigatório não preenchido']);
    }

}
