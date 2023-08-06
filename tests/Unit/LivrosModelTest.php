<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Livros;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class LivrosModelTest extends TestCase
{
    //SetUp
    //Execução
    //Assert 
   public $livros ;
   public $livrosDataSource ; 
   public function setUp() : void {
        parent::setUp(); 
        $this->livros = new Livros; 
        $this->livrosDataSource = ['titulo' => 'TestCase' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
        'editoras_nome' => 'TestCase' , 
        'autores_nome' => 'TestCase' ]; 
        
   }



   public function testeMeuPerfilLivrosDoUsuario_RetornaNull() :void {
        //SetUp
        
        $id = 0 ; 
        //Execução
        $livrosDoUsuario = $this->livros->meuPerfilLivrosDoUsuario($id);

        //Assert      
        $this->assertNull($livrosDoUsuario);
        
   }
   
   public function testeMeuPerfilLivrosDoUsuario_RetornaDataSource() : void { 
        //SetUp
        DB::beginTransaction(); 
        $createUser = ['name' => 'TestCase' ,'email' =>'testCase@email.com' , 'password' => 'testCase'];
        //Execução 
        $user = User::create($createUser);
        $this->livrosDataSource['users_id'] = $user->id ; 
        $adicionarLivros = $this->livros->adicionarLivros( $this->livrosDataSource );

        $livrosDoUsuario = $this->livros->meuPerfilLivrosDoUsuario($user->id);

        $this->assertTrue($livrosDoUsuario->count() > 0  );

        //Assert 
        DB::rollBack();
    }
    public function testeAdicionarLivros_RetornaDataSource() : void {
        //SetUp
        DB::beginTransaction(); 
        $createUser = ['name' => 'TestCase' ,'email' =>'testCase@email.com' , 'password' => 'testCase'];
        //Execução 
        $user = User::create($createUser);
        $this->livrosDataSource['users_id'] = $user->id ; 
        $adicionarLivros = $this->livros->adicionarLivros( $this->livrosDataSource );
        //Assert 
        $this->assertInstanceOf(Livros::class , $adicionarLivros); 
        $this->assertEquals( $this->livrosDataSource['titulo']  , $adicionarLivros->titulo );
        $this->assertEquals( $this->livrosDataSource['descricao']  , $adicionarLivros->descricao );
        $this->assertEquals( $this->livrosDataSource['isbn']  , $adicionarLivros->isbn );
        $this->assertEquals( $this->livrosDataSource['visibilidade']  , $adicionarLivros->visibilidade );
        $this->assertEquals( $this->livrosDataSource['users_id']  , $adicionarLivros->users_id );
        DB::rollBack();
    }

    public function testeEditarLivros() : void {
        //Setup
        DB::beginTransaction();
        
        $createUser = ['name' => 'TestCase' ,'email' =>'testCase@email.com' , 'password' => 'testCase'];
        //Execução 
        $user = User::create($createUser);
        $livrosDataSourceEditar = ['titulo' => 'TestCase Editar Model' , 'descricao' => 'TestCase Editar Model' , 'visibilidade' => 0 , 'isbn' => null ,
        'editoras_nome' => 'TestCase Editar Model' , 
        'autores_nome' => 'TestCase Editar Model' , 
        'id' => $user->id ];
    
        $adicionarLivros = $this->livros->adicionarLivros( $this->livrosDataSource );
        
        $editarLivros = $this->livros->editarLivros($livrosDataSourceEditar);
        
        //Assert 
        $this->assertEquals( $livrosDataSourceEditar['titulo']  , $editarLivros->titulo );
        $this->assertEquals( $livrosDataSourceEditar['descricao']  , $editarLivros->descricao );
        $this->assertEquals( $livrosDataSourceEditar['isbn']  , $editarLivros->isbn );
        $this->assertEquals( $livrosDataSourceEditar['visibilidade']  , $editarLivros->visibilidade );
        $this->assertEquals( $adicionarLivros->users_id  , $editarLivros->users_id );
        DB::rollBack();
        }
}
