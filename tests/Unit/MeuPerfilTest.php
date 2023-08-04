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

    public function setUp() :void {
        parent::setUp();
        $this->meuPerfil = new MeuPerfilController();
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
    public function testeAdicionarLivros_RetornaLivrosDataSource(){
        //Setup 
        DB::beginTransaction();

        $createUser = ['name' => 'TestCase' ,'email' =>'testCase@email.com' , 'password' => 'testCase'];
        $user = User::create($createUser);
        
        $livros = Request::create('meuperfil/adicionarLivros' , 'POST' ,
            ['users_id'=> $user->id , 
             'titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
             'editoras_nome' => 'TestCase' , 
             'autores_nome' => 'TestCase' ]);
        
        //Execução
        $adicionarLivros = $this->meuPerfil->adicionarLivros($livros);
        dd( $adicionarLivros );
        //Assert 
        $this->assertInstanceOf(Livros::class , $adicionarLivros);
        DB::rollBack();
    }


    // public function testeIndex_RetornaViewComDados() : void {
    //     //Setup
    //     $dataSource = [
    //         'users_id' , 
    //         'livros_id' , 'nome' , 'descricao' , 'isbn' , 'visibilidade' ,
    //         'autores_id', 'autores_nome' , 
    //         'editoras_id' , 'editoras_nome',
    //         'paginacao' ];

    //      
    //     //Execução
    //     $this->meuPerfil->SetIdTeste(1);
    //     $view = $this->meuPerfil->index(); 

    //     $viewDataSource = $view->getData();
    //     $viewDataSourceColunas = array_keys($viewDataSource->getAttributes());
    //     //Assert 
    //     $this->assertInstanceOf(View::class , $view );
    //     $this->assertEquals('meuperfil' , $view->getName() );
        
    //     $this->assertEquals($dataSource , $viewDataSource );

    // }

    public function testeEditarLivros_RetornaLivrosDataSource(){
        //Setup
         

        $livros = Livros::getModel();
        //Execucao 
        $editarLivros = $this->meuPerfil->editarLivros($livros);

        //Asssert
        $this->assertInstanceOf(Livros::class , $editarLivros );

    }

    

    public function testeRemoverLivros_RetornaTrue(){
        //Setup 
        
        $id = 1 ; 
        //Execução
        $removerLivros = $this->meuPerfil->removerLivros($id);


        //Assert 
        $this->assertEquals(true , $removerLivros);
    }


}
