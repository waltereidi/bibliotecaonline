<?php

namespace Tests\Feature;

use Illuminate\View\View; 

use Tests\TestCase;
use Illuminate\Http\Request;
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

        //Execução 
        $view = $meuPerfil->index();
        //Assert 
        $this->assertInstanceOf(View::class , $view );
        $this->assertEquals('auth.login' , $view->getName() );
    }
    public function testeIndex_SemLivros_RetornaViewComDataSourceLivrosNullPerfil1() : void {

        //Setup 
        $meuPerfil = new MeuPerfilController();
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
        $this->assertIsInt($viewDataSource['dataSourceQuantidadeLivros']);
    }
    public function testeAdicionarLivros_RetornaLivrosDataSource() : void {
        //Setup 
        $meuPerfil = new MeuPerfilController();

        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
            'capalivro' => null , 'editoras_nome' => 'TestCase' , 
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
            'capalivro' => null , 'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]); 

        //Execução 
        $adicionarLivros = $meuPerfil->adicionarLivros($livros);
        
        //Assert 
        $this->assertStringContainsString(  '401', $adicionarLivros  );
    

    }
    public function testeAdicionarLivros_RetornaErroDataSourceIncorreto() : void {
        
        //Setup 
        $meuPerfil = new MeuPerfilController();
        $user = User::where('email' , 'testCase@email.com')->first();
        
        $meuPerfil->setUsersId($user->id);
        //Execução 
        $meuPerfil->setUsersId(0);
        $livrosRequest = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            [
             'titulo' => '' , 'descricao' => 'TestCaseEditar' , 'visibilidade' => 0 , 'isbn' => null ,
             'capalivro' => null , 'editoras_nome' => 'TestCaseEditar' , 
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
             'autores_nome' => 'TestCase'  , 
            'capalivro' => 'https://img.freepik.com/free-psd/book-hardcover-mockup_125540-225.jpg?w=1060&t=st=1691442549~exp=1691443149~hmac=dcdee8ad230673bf52de12265b676387c937a4cf1f04434ed43a26ea2c051d48'
        ]); 

       $user = User::where('email' , 'testCase@email.com')->first();
        
        $meuPerfil->setUsersId($user->id);
        
        //Execucao 
        $adicionarLivros = $meuPerfil->adicionarLivros($livros);
        $editarLivrosRequest = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['id' => $adicionarLivros->id , 
             'titulo' => 'TestCaseEditar' , 'descricao' => 'TestCaseEditar' , 'visibilidade' => 0 , 'isbn' => null ,
             'capalivro' => null , 'editoras_nome' => 'TestCaseEditar' , 
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
            'capalivro' => null , 'editoras_nome' => 'TestCase' , 
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
            'capalivro' => null , 'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]); 
        $user = User::where('email' , 'testCase@email.com')->first();
        $meuPerfil->setUsersId($user->id);

        //Execução 
        $livro = $meuPerfil->removerLivros(0);

        //Assert 
        $this->assertFalse($livro);
   
    }
    public function testeGetPaginacao_retornaNull() : void {
        //Setup
        $meuPerfil = new MeuPerfilController(); 
        $user = User::where('email' , 'testCase@email.com')->first();
        $request = Request::create('meuperfil/getPaginacaoLivrosDoUsuario' , 'POST' ,
            ['users_id' => $user->id , 'paginacao' => 999 ]); 
        //Execução 
        $livrosDoUsuarioPaginacao = $meuPerfil->getPaginacaoLivrosDoUsuario($request); 
        
        //Assert 
        $this->assertNull($livrosDoUsuarioPaginacao );
    }

    public function testeValidarLivrosRequest_UrlInvalida_retornaErro() : void {
        //Setup
        $meuPerfil = new MeuPerfilController();
        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase'  , 
            'capalivro' => 'testeURLInvalida',
        ]); 
        $meuPerfil->SetUsersId(0);                
       //Execução
        $validator = $meuPerfil->validarLivrosRequest( $livros );
        $dados = $validator['dados'];
        $validador = $validator['validador'];
        //Assert 
        $this->assertTrue($validador->fails());
        $this->assertNotEmpty($dados);

    }
    public function testeValidarLivrosRequest_UrlInvalida_retornaTrue() : void {
        //Setup
        $meuPerfil = new MeuPerfilController();
        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase'  , 
            'capalivro' => null ,
        ]); 
        $meuPerfil->SetUsersId(0);
                
       //Execução
        $validator = $meuPerfil->validarLivrosRequest( $livros );
        $dados = $validator['dados'];
        $validador = $validator['validador'];
        //Assert 
        $this->assertFalse($validador->fails());
        $this->assertNotEmpty($dados);

    }
    
}