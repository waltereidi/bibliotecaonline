<?php

namespace Tests\Unit\Request\MeuPerfil;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MeuPerfil;

class PostLivrosMeuPerfilRequestTest extends TestCase
{
    public $user;
    public $url;
    public $dados;
    public $meuperfil ;
    public function SetUp(): void
    {
        parent::setUp();
        $this->user = User::where('email', '=', 'testCase@email.com')->first();
        Auth::loginUsingId($this->user->id);
        $this->url = '/api/meuperfil/postLivrosMeuPerfil';
        $this->meuperfil = MeuPerfil::where('users_id' ,'=' , $this->user->id );
        $this->dados = ['Authorization' => 'Bearer ' . $this->user->api_token ,
            'quantidade' => 20 ,
            'pagina' => 0 ,
            'meuperfil_id' => 1 ,
        ];
    }

    public function testePostRequest_SemToken_Retorna401(): void
    {
        //Setup
        $dados = [
            'Authorization' => 'Bearer ',
        ];
        //Execução
        $retorno = $this->post($this->url, $dados);
        //Assert
        $this->assertEquals(401, $retorno->getStatusCode());
    }

    public function testePostLivrosMeuPerfilRetorna200(): void
    {
        //setup
        $dados = $this->dados;
        //execucao
        $request = $this->post($this->url, $dados);
        //assert
        $this->assertEquals($request->getStatusCode(), 200);
    }
    public function testePostLivrosMeuPerfilRetornaDadosIncorretos_naoespecificado_Retorna302(): void
    {
        //setup
        $dados =  $this->dados;
        unset($dados['quantidade']);
        unset($dados['pagina']);
        unset($dados['meuperfil_id']);

        //execucao
        $retorno = $this->post($this->url, $dados);

        //assert
        $this->assertEquals($retorno->getStatusCode(), 302);
        $retorno->assertSessionHasErrors('quantidade', 'Campo obrigatório não preenchido');
        $retorno->assertSessionHasErrors('pagina', 'Campo obrigatório não preenchido');
        $retorno->assertSessionHasErrors('meuperfil_id', 'Campo obrigatório não preenchido');

    }
    public function testPostLivrosMeuPerfil_BuscaVazia_Retorna204() : void
    {
        //setup
        $dados = $this->dados ;
        $dados['meuperfil_id'] = 0 ;

        //execucao
        $retorno = $this->post($this->url , $dados);
        //assert
        $this->assertEquals($retorno->getStatusCode() , 204);

    }



}
