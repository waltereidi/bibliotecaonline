<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\PaginaInicialController;
use App\Http\Requests\Paginainicial\PostBuscaIndiceRequest;
use App\Http\Requests\Paginainicial\PostBuscaRequest;
use App\Models\Aplicativo;
use Tests\TestCase;
use Illuminate\View\View;

class PaginaInicialControllerTest extends TestCase
{
    public $paginaInicialController;
    public $dadosBuscaIndice;
    public $dadosBusca;
    public $aplicativo ;
    public function setUp() :void
    {
        parent::setUp();
        $this->paginaInicialController = new PaginaInicialController;
        $this->dadosBuscaIndice=new PostBuscaIndiceRequest([
            'quantidade'=>10 ,
            'iniciopagina'=>0,
            'busca'=>[['indice'=>'testCase' , 'tipo'=>'testCase'],
            ['indice'=>'testCase2' , 'tipo'=>'testCase']] ]);
        $this->dadosBusca = new PostBuscaRequest(['busca'=>'??????Busca?????']);
        $this->aplicativo = Aplicativo::where('nome' ,'=' ,'bibliotecaonline')->first();

    }
    public function testIndex_RetornaViewComTokenAplicativo(){
        //setup

        $PaginaInicial = new PaginaInicialController();
        $view = $PaginaInicial->index();
        $viewDataSource = $view->getData();

        $this->assertInstanceOf(View::class , $view );
        $this->assertEquals('paginainicial' , $view->getName() );
        $this->assertEquals($viewDataSource['token_aplicativo'] ,$this->aplicativo->token_aplicacao);


    }
     public function testePostBuscaIndice_BuscaSemResultados_Retorna204()
     {
         //setup
         //execucao
         $retorno= $this->paginaInicialController->postBuscaIndice( $this->dadosBuscaIndice);

         //assert
         $this->assertEquals(204 , $retorno->getStatusCode());


    }
    public function testePostBuscaIndice_BuscaComResultados_Retorna200()
    {
        //setup
        $dadosBuscaIndice=new PostBuscaIndiceRequest([
            'quantidade'=>10 ,
            'iniciopagina'=>0,
            'busca'=>[['indice'=>'TestCase' , 'tipo'=>'genero'],
            ['indice'=>'TestCase' , 'tipo'=>'editoras']] ]);
        //execucao
        $retorno= $this->paginaInicialController->postBuscaIndice( $dadosBuscaIndice);
        $dadosRetorno = $retorno->getData();
        //assert
        $this->assertEquals(200 , $retorno->getStatusCode() );
        $this->assertNotEmpty( $dadosRetorno->livros);
    }
    public function testePostBusca_BuscaSemResultados_Retorna204()
    {
        //setup

        //execucao
        $retorno = $this->paginaInicialController->postBusca($this->dadosBusca);

        //assert

        $this->assertEquals(204 , $retorno->getStatusCode());

    }
    public function testePostBusca_BuscaComResultados_Retorna200()
    {
        //setup
        $dadosBusca = new PostBuscaRequest(['busca'=>'TestCase']);
        //execucao
        $retorno = $this->paginaInicialController->postBusca($dadosBusca);
        //assert
        $this->assertEquals(200 , $retorno->getStatusCode());

    }
}
