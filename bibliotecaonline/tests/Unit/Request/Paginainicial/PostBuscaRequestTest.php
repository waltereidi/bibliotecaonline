<?php

namespace Tests\Unit\Request\Paginainicial;

use App\Models\Aplicativo;
use Tests\TestCase;
use Illuminate\Support\Str;

class PostBuscaRequestTest extends TestCase
{
    public $aplicativo;
    public $url ;
    public $dados ;

    public function SetUp(): void
    {
        parent::setUp();
        $this->aplicativo = Aplicativo::where('nome', '=', 'bibliotecaonline')->first();
        $this->url = '/api/paginainicial/postBusca';
        $this->dados=['Authorization'=>'Bearer '.$this->aplicativo->token_aplicacao,
        'busca'=>'??????Busca?????' ];
    }

    public function testeBusca_TokenInvalido_Retorna401():void
    {
        //setup
        $dados = $this->dados ;
        $dados['Authorization'] = 'Bearer ';

        //execucao
        $retorno = $this->post($this->url , $dados );

        //Assert
        $this->assertEquals($retorno->getStatusCode() , 401 );
    }
    public function testeBusca_Retorna204():void
    {
        //setup
        $dados = $this->dados ;

        //execucao
        $retorno = $this->post($this->url , $dados);

        //Assert
        $this->assertEquals($retorno->getStatusCode() , 204);
    }
    public function testeBusca_DadosNaoPreenchidos_retorna302(): void
    {
        //setup
        $dados = $this->dados ;
        unset($dados['busca']);

        //execucao
        $retorno = $this->post($this->url , $dados ) ;

        //assert
        $this->assertEquals($retorno->getStatusCode() , 302);
        $retorno->assertSessionHasErrors('busca' , 'Campo obrigatório não preenchido' );

    }
    public function testeBusca_LimiteDeCaracteres_retorna302(): void
    {
        //setup
        $dados = $this->dados ;
        $dados['busca'] = Str::random(61);
        //execucao
        $retorno = $this->post($this->url , $dados ) ;

        //assert
        $this->assertEquals($retorno->getStatusCode() , 302);
        $retorno->assertSessionHasErrors('busca' , 'Limite de caracteres excedido' );

    }
    public function testeBusca_CaracteresMinimosNaoPreenchido_retorna302(): void
    {
        //setup
        $dados = $this->dados ;
        $dados['busca'] = 'a';
        //execucao
        $retorno = $this->post($this->url , $dados ) ;

        //assert
        $this->assertEquals($retorno->getStatusCode() , 302);
        $retorno->assertSessionHasErrors('busca' , 'Campo deve possuir ao menos 3 caracteres' );

    }


}
