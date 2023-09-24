<?php

namespace Tests\Unit\Request\Paginainicial;

use App\Models\Aplicativo;
use Tests\TestCase;
use Illuminate\Support\Str;
class PostBuscaIndiceRequestTest extends TestCase
{
    public $aplicativo;
    public $url ;
    public $dados ;

    public function SetUp(): void
    {
        parent::setUp();
        $this->aplicativo = Aplicativo::where('nome', '=', 'bibliotecaonline')->first();
        $this->url = '/api/paginainicial/postBuscaIndice';
        $this->dados=['Authorization'=>'Bearer '.$this->aplicativo->token_aplicacao,
        'quantidade'=>10 ,
        'iniciopagina'=>0,
        'busca'=>[['indice'=>'testCase' , 'tipo'=>'testCase'],
        ['indice'=>'testCase2' , 'tipo'=>'testCase']] ];
    }
    public function testeBuscaIndice_TokenInvalido_Retorna401():void
    {
        //setup
        $dados = $this->dados ;
        $dados['Authorization'] = 'Bearer ';

        //execucao
        $retorno = $this->post($this->url , $dados );

        //Assert
        $this->assertEquals($retorno->getStatusCode() , 401 );
    }
    public function testeBuscaIndice_Retorna204():void
    {
        //setup
        $dados = $this->dados ;

        //execucao
        $retorno = $this->post($this->url , $dados);

        //Assert
        $this->assertEquals($retorno->getStatusCode() , 204);
    }
    public function testeBuscaIndice_dadosNaoPreenchidos_Retorna302():void
    {
        //setup
        $dados = $this->dados ;
        unset($dados['busca']);
        unset($dados['quantidade']);
        unset($dados['iniciopagina']);

        //execucao
        $retorno = $this->post($this->url , $dados) ;

        //assert
        $this->assertEquals(302 , $retorno->getStatusCode());
        $retorno->assertSessionHasErrors('busca','Campo obrigatório não preenchido');
        $retorno->assertSessionHasErrors('quantidade','Campo obrigatório não preenchido');
        $retorno->assertSessionHasErrors('iniciopagina','Campo obrigatório não preenchido');

    }
    public function testeBuscaIndice_arrayMalformado_Retorna302():void
    {
        //setup
        $dados = $this->dados ;
        $dados['busca'][0]['indice']=null;
        $dados['busca'][1]['tipo']=null;

        //execucao
        $retorno = $this->post($this->url , $dados) ;

        //assert
        $this->assertEquals(302 , $retorno->getStatusCode());
        $retorno->assertSessionHasErrors('busca.*.indice','Campo obrigatório não preenchido');
        $retorno->assertSessionHasErrors('busca.*.tipo','Campo obrigatório não preenchido');

    }
    public function testeBuscaIndice_LimiteDeCaracteres_Retorna302():void
    {
        //setup
        $dados = $this->dados ;
        $dados['busca'][0]['indice']=Str::random(31);
        $dados['busca'][0]['tipo']=Str::random(31);

        //execução
        $retorno = $this->post($this->url , $dados);

        //assert
        $this->assertEquals(302, $retorno->getStatusCode());
        $retorno->assertSessionHasErrors('busca.*.indice' , 'Limite de caracteres excedido');
        $retorno->assertSessionHasErrors('busca.*.tipo' , 'Limite de caracteres excedido');

    }



}
