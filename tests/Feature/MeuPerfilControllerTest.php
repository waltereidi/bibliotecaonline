<?php

namespace Tests\Feature;

use Illuminate\View\View; 

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Livros; 
use App\Models\User;



use App\Http\Controllers\MeuPerfilController ; 



class MeuPerfilControllerTest extends TestCase
{
    //Setup 
    //Execução 
    //Assert 

    public function testeIndex_SemAutenticacao_RetornaLoginView() : void {
        //Setup 
        $meuPerfil = new MeuPerfilController();

        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]); 

       $user = User::where('email' , 'testCase@email.com')->first();
        //Execução 
        $view = $meuPerfil->index();
        //Assert 
        $this->assertInstanceOf(View::class , $view );
        $this->assertEquals('auth.login' , $view->getName() );
    }
    public function testeIndex_SemLivros_RetornaViewComDataSourceLivrosNullPerfil1() : void {

        //Setup 
        $meuPerfil = new MeuPerfilController();

        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]); 

        $user = User::where('email' , 'testCase@email.com')->first();
        //Execução 
        $meuPerfil->SetUsersId(0);
        $view = $meuPerfil->index();
        $viewDataSource = $view->getData();
        //Assert 
        $this->assertEquals($meuPerfil->users_id , 0 );
        $this->assertInstanceOf(View::class , $view ); 
        $this->assertEquals('meuperfil' , $view->getName() );
        $this->assertNotEmpty( $viewDataSource );
        $this->assertNull($viewDataSource['dataSourceLivros']);
        $this->assertNull($viewDataSource['dataSourceUsers']);
    }
    public function testeAdicionarLivros_RetornaLivrosDataSource() : void {
        //Setup 
        $meuPerfil = new MeuPerfilController();

        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]); 

       $user = User::where('email' , 'testCase@email.com')->first();
        
        $meuPerfil->setUsersId($user->id);

        
        //Execução
        $adicionarLivros = $meuPerfil->adicionarLivros($livros);
        //Assert 
        $this->assertInstanceOf(Livros::class , $adicionarLivros);
        $this->assertEquals($livros['titulo'], $adicionarLivros->titulo );
        $this->assertEquals($livros['descricao'], $adicionarLivros->descricao );
        $this->assertEquals($livros['visibilidade'], $adicionarLivros->visibilidade );
        $this->assertNotEmpty( $adicionarLivros->autores_id );
        $this->assertNotEmpty( $adicionarLivros->editoras_id );
        $this->assertNotEmpty( $adicionarLivros->users_id );
        
    }
    public function testeAdicionarLivros_NaoAutenticado_Retorna401() : void {
        
        //Setup 
        $meuPerfil = new MeuPerfilController();

        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]); 

        
        
        //Execução 
        $adicionarLivros = $meuPerfil->adicionarLivros($livros);
        
        //Assert 
        $this->assertStringContainsString(  '401', $adicionarLivros  );
    

    }
    public function testeAdicionarLivros_RetornaErroDataSourceIncorreto() : void {
        
        //Setup 
        $meuPerfil = new MeuPerfilController();

        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]); 

       $user = User::where('email' , 'testCase@email.com')->first();
        
        $meuPerfil->setUsersId($user->id);
        //Execução 
        $meuPerfil->setUsersId(0);
        $livrosRequest = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            [
             'titulo' => '' , 'descricao' => 'TestCaseEditar' , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCaseEditar' , 
             'autores_nome' => 'TestCaseEditar' ]); 
        $adicionarLivros = $meuPerfil->adicionarLivros($livrosRequest);
        
        //Assert 
       
        $this->assertIsObject( $adicionarLivros);
        $this->assertEquals( 419 , $adicionarLivros->getStatusCode() );
        
    }





    public function testeEditarLivros_RetornaLivrosDataSource() : void{
        //Setup
        $meuPerfil = new MeuPerfilController();
        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]); 

       $user = User::where('email' , 'testCase@email.com')->first();
        
        $meuPerfil->setUsersId($user->id);
        
        //Execucao 
        $adicionarLivros = $meuPerfil->adicionarLivros($livros);
        $editarLivrosRequest = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['id' => $adicionarLivros->id , 
             'titulo' => 'TestCaseEditar' , 'descricao' => 'TestCaseEditar' , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCaseEditar' , 
             'autores_nome' => 'TestCaseEditar' ]); 
        $editarLivros = $meuPerfil->editarLivros($editarLivrosRequest);
        //Asssert
        $this->assertInstanceOf(Livros::class , $editarLivros );
        $this->assertEquals($editarLivrosRequest['titulo'], $editarLivros->titulo );
        $this->assertEquals($editarLivrosRequest['descricao'], $editarLivros->descricao );
        $this->assertEquals($editarLivrosRequest['visibilidade'], $editarLivros->visibilidade );
        $this->assertNotEmpty( $editarLivros->autores_id );
        $this->assertNotEmpty( $editarLivros->editoras_id );
        $this->assertNotEmpty( $editarLivros->users_id );
  
    }

    public function testeRemoverLivros_RetornaTrue() : void {
        //Setup 
        $meuPerfil = new MeuPerfilController();
        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]); 

       $user = User::where('email' , 'testCase@email.com')->first();
        
        $meuPerfil->setUsersId($user->id);

        //Execução
        $adicionarLivros = $meuPerfil->adicionarLivros($livros);
        $livro = $meuPerfil->removerLivros($adicionarLivros->id); 
        
        //Assert 
        $this->assertTrue($livro);
       
        
        
    }
    public function testeRemoverLivros_RetornaFalse() : void {
        //Setup
        $meuPerfil = new MeuPerfilController();
        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]); 

        
        $user = User::where('email' , 'testCase@email.com')->first();
        
        $meuPerfil->setUsersId($user->id);

        //Execução 
        $livro = $meuPerfil->removerLivros(0);

        //Assert 
        $this->assertFalse($livro);
   
    }
    
}
