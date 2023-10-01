<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\LivrosController;
use Tests\TestCase;
use Illuminate\View\View;
use App\Models\Aplicativo;
use App\Models\Livros;
class LivrosControllerTest extends TestCase
{
    public $livrosController ;
    public $aplicativo ;

    public function SetUp() : void
    {
        parent::SetUp();
        $this->livrosController = new LivrosController;
        $this->aplicativo = Aplicativo::where('nome' ,'=' ,'bibliotecaonline')->first();
    }

    public function testGetLivro_RetornaViePaginainicialComToken(){
        //setup

        $view = $this->livrosController->getLivro(0);
        $viewDataSource = $view->getData();

        $this->assertInstanceOf(View::class , $view );
        $this->assertEquals('paginainicial' , $view->getName() );
        $this->assertEquals($viewDataSource['token_aplicativo'] ,$this->aplicativo->token_aplicacao);



    }
    public function testGetLivro_RetornaViewComLivro() :void{
        //setup
        $livro = Livros::first();

        $view = $this->livrosController->getLivro($livro->id);
        $viewDataSource = $view->getData();

        $this->assertInstanceOf(View::class , $view );
        $this->assertEquals('livros' , $view->getName() );
        $this->assertNotEmpty($viewDataSource['livro']);


    }
}
