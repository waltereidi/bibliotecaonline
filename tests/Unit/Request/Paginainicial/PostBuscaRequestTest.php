<?php

namespace Tests\Unit\Request\Paginainicial;

use Tests\TestCase;
use App\Models\Aplicativo;
use stdClass;

class PostBuscaRequestTest extends TestCase
{
    public $user;
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
        'indice'=>['indice'=>'testeCase' , 'tipo'=>'testCase'] ];
    }
}
