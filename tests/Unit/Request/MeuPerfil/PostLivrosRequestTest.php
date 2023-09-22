<?php

namespace Tests\Unit\Request\MeuPerfil;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;

class PostLivrosRequestTest extends TestCase
{
    public $user;
    public $dados;
    public $url;
    public function SetUp(): void
    {

        parent::setUp();
        $this->user = User::where('email', '=', 'testCase@email.com')->first();
        Auth::loginUsingId($this->user->id);
        $this->dados = [
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'users_id' => 1,
            'titulo' => 'TestCase Request',
            'descricao' => 'TestCase Request',
            'visibilidade' => 1,
            'isbn' => 'TestCase',
            'editoras_nome' => 'TestCase Request',
            'autores_nome' => 'TestCase Request',
            'capalivro' => null,
            'genero' => null,
            'idioma' => null,
            'urldownload' => 'https://www.php.net/'
        ];
        $this->url = '/api/meuperfil/postLivros';
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

    public function testePostRequestLivrosRetorna204(): void
    {
        //setup
        $dados = $this->dados;
        //execucao
        $request = $this->post($this->url, $dados);
        //assert
        $this->assertEquals($request->getStatusCode(), 204);
    }
    public function testePostRequestLivrosRetornaDadosIncorretos_naoespecificado_Retorna302(): void
    {
        //setup
        $dados =  $this->dados;
        unset($dados['titulo']);
        unset($dados['autores_nome']);
        unset($dados['editoras_nome']);
        unset($dados['urldownload']);
        unset($dados['visibilidade']);
        unset($dados['users_id']);
        //execucao
        $retorno = $this->post($this->url, $dados);

        //assert
        $this->assertEquals($retorno->getStatusCode(), 302);
        $retorno->assertSessionHasErrors('titulo', 'Campo obrigatório não preenchido');
        $retorno->assertSessionHasErrors('autores_nome', 'Campo obrigatório não preenchido');
        $retorno->assertSessionHasErrors('editoras_nome', 'Campo obrigatório não preenchido');
        $retorno->assertSessionHasErrors('urldownload', 'Campo obrigatório não preenchido');
        $retorno->assertSessionHasErrors('visibilidade', 'Campo obrigatório não preenchido');
        $retorno->assertSessionHasErrors('users_id', 'Campo obrigatório não preenchido');
    }
    public function testePostRequestLivrosRetornaDadosIncorretos_limiteDeString_Retorn302(): void
    {
        //setup
        $dados = $this->dados;
        $dados['isbn'] = Str::random(21);
        $dados['titulo'] = Str::random(61);
        $dados['descricao'] = Str::random(2049);
        $dados['editoras_nome'] = Str::random(61);
        $dados['autores_nome'] = Str::random(61);
        $dados['urldownload'] = Str::random(2049);
        $dados['capalivro'] = Str::random(2049);
        $dados['genero'] = Str::random(31);
        $dados['idioma'] = Str::random(31);
        //execucao
        $retorno = $this->post($this->url, $dados);

        //assert
        $this->assertEquals($retorno->getStatusCode(), 302);
        $retorno->assertSessionHasErrors('isbn', 'Limite de caracteres excedido');
        $retorno->assertSessionHasErrors('titulo', 'Limite de caracteres excedido');
        $retorno->assertSessionHasErrors('descricao', 'Limite de caracteres excedido');
        $retorno->assertSessionHasErrors('editoras_nome', 'Limite de caracteres excedido');
        $retorno->assertSessionHasErrors('autores_nome', 'Limite de caracteres excedido');
        $retorno->assertSessionHasErrors('urldownload', 'Limite de caracteres excedido');
        $retorno->assertSessionHasErrors('capalivro', 'Limite de caracteres excedido');
        $retorno->assertSessionHasErrors('genero', 'Limite de caracteres excedido');
        $retorno->assertSessionHasErrors('idioma', 'Limite de caracteres excedido');
    }
    public function testePostRequestLivrosRetornaDadosIncorretos_urlIncorreta_Retorna302(): void
    {
        //setup
        $dados = $this->dados;
        $dados['urldownload'] = 'sdsd';
        $dados['capalivro'] = 'sdsd';

        //execucao
        $retorno = $this->post($this->url, $dados);

        //assert
        $this->assertEquals($retorno->getStatusCode(), 302);
        $retorno->assertSessionHasErrors('urldownload', 'url inválida');
        $retorno->assertSessionHasErrors('capalivro', 'url inválida');
    }
}
