<?php

namespace Tests\Unit;

use Illuminate\View\View; 
use Tests\TestCase;
use Illuminate\Http\Request;

use App\Models\MeuPerfil; 
use App\Models\Livros; 
use App\Models\Autores;
use App\Models\Editoras; 
use App\Models\Mensagens;
use App\Models\User;


use App\Http\Controllers\MeuPerfilController ; 

use Illuminate\Foundation\Mix;
use Illuminate\Support\Facades\DB;


class MeuPerfilTest extends TestCase
{
    //Setup 
    //Execução 
    //Assert 
    private $meuPerfil ;
    private $livros ;
    public function setUp() :void {
        parent::setUp();
        $this->meuPerfil = new MeuPerfilController();

        $this->livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]); 
    }

    public function testeIndex_SemAutenticacao_RetornaLoginView() : void {
    //Setup 
    
    //Execução 
    $view = $this->meuPerfil->index();
    //Assert 
    $this->assertInstanceOf(View::class , $view );
    $this->assertEquals('auth.login' , $view->getName() );
    }
    public function testeIndex_SemLivros_RetornaViewComDataSourceLivrosNullPerfil1() : void {

    //Setup 
    
    //Execução 
    $this->meuPerfil->SetUsersId(0);
    $view = $this->meuPerfil->index();
    $viewDataSource = $view->getData();
    //Assert 
    $this->assertEquals($this->meuPerfil->users_id , 0 );
    $this->assertInstanceOf(View::class , $view ); 
    $this->assertEquals('meuperfil' , $view->getName() );
    $this->assertEquals( $viewDataSource['dataSourceLivros'], null );
    $this->assertEquals($viewDataSource['dataSourceUsers'] , null );

    }
    public function testeAdicionarLivros_RetornaLivrosDataSource() : void {
        //Setup 
        DB::beginTransaction();

        $createUser = ['name' => 'TestCase' ,'email' =>'testCase@email.com' , 'password' => 'testCase'];
        $user = User::create($createUser);
        $this->meuPerfil->setUsersId($user->id);

        
        //Execução
        $adicionarLivros = $this->meuPerfil->adicionarLivros($this->livros);
        //Assert 
        $this->assertInstanceOf(Livros::class , $adicionarLivros);
        $this->assertEquals($this->livros['titulo'], $adicionarLivros->titulo );
        $this->assertEquals($this->livros['descricao'], $adicionarLivros->descricao );
        $this->assertEquals($this->livros['visibilidade'], $adicionarLivros->visibilidade );
        $this->assertNotEmpty( $adicionarLivros->autores_id );
        $this->assertNotEmpty( $adicionarLivros->editoras_id );
        $this->assertNotEmpty( $adicionarLivros->users_id );
        DB::rollBack();
    }
    public function testeAdicionarLivros_NaoAutenticado_Retorna401() : void {
        
        //Setup 
        
        //Execução 
        $adicionarLivros = $this->meuPerfil->adicionarLivros($this->livros);
        
        //Assert 
        $this->assertStringContainsString(  '401', $adicionarLivros  );
        

    }
    public function testeAdicionarLivros_RetornaErroDataSourceIncorreto() : void {
        
        //Setup 
   
        //Execução 
        $this->meuPerfil->setUsersId(0);
        $livrosRequest = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            [
             'titulo' => '' , 'descricao' => 'TestCaseEditar' , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCaseEditar' , 
             'autores_nome' => 'TestCaseEditar' ]); 
        $adicionarLivros = $this->meuPerfil->adicionarLivros($livrosRequest);
        
        //Assert 
       
        $this->assertIsObject( $adicionarLivros);
        $this->assertEquals( 419 , $adicionarLivros->getStatusCode() );
    }




    public function testeRemoverLivros_RetornaTrue() : void {
        //Setup 
        DB::beginTransaction();

        $createUser = ['name' => 'TestCase' ,'email' =>'testCase@email.com' , 'password' => 'testCase'];
        $user = User::create($createUser);
        $this->meuPerfil->setUsersId($user->id);

        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]);
        
        //Execução
        $adicionarLivros = $this->meuPerfil->adicionarLivros($livros);
        $livro = $this->meuPerfil->removerLivros($adicionarLivros->id); 
        
        //Assert 
        $this->assertTrue($livro);

        DB::rollBack();
    }
    public function testeRemoverLivros_RetornaFalse() : void {
        //Setup
        DB::beginTransaction();

        //Execução 
        $livro = $this->meuPerfil->removerLivros(0);

        //Assert 
        $this->assertFalse($livro);
        DB::rollBack();
    }

    public function testeEditarLivros_RetornaLivrosDataSource() : void{
        //Setup
        DB::beginTransaction();
        $createUser = ['name' => 'TestCase' ,'email' =>'testCase@email.com' , 'password' => 'testCase'];
        $user = User::create($createUser);
        $this->meuPerfil->setUsersId($user->id);

        //Execucao 
        $adicionarLivros = $this->meuPerfil->adicionarLivros($this->livros);
        $editarLivrosRequest = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['id' => $adicionarLivros->id , 
             'titulo' => 'TestCaseEditar' , 'descricao' => 'TestCaseEditar' , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCaseEditar' , 
             'autores_nome' => 'TestCaseEditar' ]); 
        $editarLivros = $this->meuPerfil->editarLivros($editarLivrosRequest);
        //Asssert
        $this->assertInstanceOf(Livros::class , $editarLivros );
        $this->assertEquals($editarLivrosRequest['titulo'], $editarLivros->titulo );
        $this->assertEquals($editarLivrosRequest['descricao'], $editarLivros->descricao );
        $this->assertEquals($editarLivrosRequest['visibilidade'], $editarLivros->visibilidade );
        $this->assertNotEmpty( $editarLivros->autores_id );
        $this->assertNotEmpty( $editarLivros->editoras_id );
        $this->assertNotEmpty( $editarLivros->users_id );
        DB::rollBack();
    }

    
}
