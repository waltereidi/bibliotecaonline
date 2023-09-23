<?php

namespace Tests\Unit\Request\Paginainicial;

use App\Models\Aplicativo;
use Tests\TestCase;
use stdClass;

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
        'busca'=>null ];
    }
    public function testeBuscaIndice_TokenInvalido_Retorna401():void
    {
        //setup
        $dados = $this->dados ;
        $dados['Authorization'] = 'Bearer ';

        //execucao
        $retorno = $this->post($this->url , $this->dados );

        //Assert
        $this->assertEquals($retorno->getStatusCode() , 401 );
    }
    public function testeBuscaIndice_Retorna204():void
    {
        //setup
        $dados = $this->dados ;

        //execucao
        $retorno = $this->post($this->url , $this->dados);

        //Assert
        $this->assertEquals($retorno->getStatusCode() , 204);
    }



}
