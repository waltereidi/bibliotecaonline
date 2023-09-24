<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Livros;
use App\Models\User;

class LivrosModelTest extends TestCase
{
    public $livros ;
    public $user ;

    public function setUp():void
    {
        parent::setUp();
        $this->livros = new Livros() ;
        $this->user = User::where('email' , 'testCase@email.com')->first();
    }
    public function testeMeuPerfilLivrosDoUsuario_RetornaNull(): void
    {
        //SetUp

        $id = 0;
        //Execução
        $livrosDoUsuario = $this->livros->meuPerfilLivrosDoUsuario($id);

        //Assert
        $this->assertNull($livrosDoUsuario);
    }
    public function testeMeuPerfilLivrosDoUsuario_ComPaginacao_RetornaNull(): void
    {
        //SetUp

        $id = 0;
        //Execução
        $livrosDoUsuario = $this->livros->meuPerfilLivrosDoUsuario($id, 999);
        //Assert
        $this->assertNull($livrosDoUsuario);
    }

    public function testeMeuPerfilLivrosDoUsuario_RetornaDataSource(): void
    {
        //SetUp
        $livros = new Livros();
        $livrosDataSource = [
            'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
            'capalivro' => null, 'editoras_nome' => 'TestCase',
            'autores_nome' => 'TestCase'
        ];
        $user = User::where('email', 'testCase@email.com')->first();

        //Execução

        $livrosDataSource['users_id'] = $this->user->id;
        $adicionarLivros = $this->livros->adicionarLivros($livrosDataSource);

        $livrosDoUsuario = $this->livros->meuPerfilLivrosDoUsuario($this->user->id);
        $validarChaves = get_object_vars($livrosDoUsuario[0]);
        //Assert
        $this->assertNotEmpty($livrosDoUsuario);
        $this->assertIsObject($livrosDoUsuario);
        $this->assertArrayHasKey('id', $validarChaves);
        $this->assertArrayHasKey('titulo', $validarChaves);
        $this->assertArrayHasKey('descricao', $validarChaves);
        $this->assertArrayHasKey('visibilidade', $validarChaves);
        $this->assertArrayHasKey('isbn', $validarChaves);
        $this->assertArrayHasKey('editoras_nome', $validarChaves);
        $this->assertArrayHasKey('autores_nome', $validarChaves);
        $this->assertArrayHasKey('capalivro', $validarChaves);
        $this->assertArrayHasKey('genero', $validarChaves);
        $this->assertArrayHasKey('idioma', $validarChaves);
    }
    public function testeAdicionarLivros_RetornaDataSource(): void
    {
        //SetUp
        $livros = new Livros();
        $livrosDataSource = [
            'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
            'capalivro' => null, 'editoras_nome' => 'TestCase',
            'autores_nome' => 'TestCase', 'genero' => 'Ficção Ciêntifica', 'idioma' => 'Inglês'
        ];
        $user = User::where('email', 'testCase@email.com')->first();

        //Execução

        $livrosDataSource['users_id'] = $this->user->id;
        $adicionarLivros = $this->livros->adicionarLivros($livrosDataSource);
        //Assert
        $this->assertInstanceOf(Livros::class, $adicionarLivros);
        $this->assertEquals($livrosDataSource['titulo'], $adicionarLivros->titulo);
        $this->assertEquals($livrosDataSource['descricao'], $adicionarLivros->descricao);
        $this->assertEquals($livrosDataSource['isbn'], $adicionarLivros->isbn);
        $this->assertEquals($livrosDataSource['visibilidade'], $adicionarLivros->visibilidade);
        $this->assertEquals($livrosDataSource['users_id'], $adicionarLivros->users_id);
        $this->assertEquals($livrosDataSource['genero'], $adicionarLivros->genero);
        $this->assertEquals($livrosDataSource['idioma'], $adicionarLivros->idioma);
    }

    public function testeEditarLivros(): void
    {
        //Setup
        $livros = new Livros();


        $livrosDataSource = [
            'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
            'capalivro' => null, 'editoras_nome' => 'TestCase',
            'autores_nome' => 'TestCase',
            'users_id' => $this->user->id
        ];
        //Execução

        $adicionarLivros = $this->livros->adicionarLivros($livrosDataSource);
        $livrosDataSourceEditar = [
            'titulo' => 'TestCase Editar Model', 'descricao' => 'TestCase Editar Model', 'visibilidade' => 0, 'isbn' => null,
            'capalivro' => null, 'editoras_nome' => 'TestCase Editar Model',
            'autores_nome' => 'TestCase Editar Model', 'genero' => 'Românce', 'idioma' => 'Inglês',
            'id' => $adicionarLivros->id
        ];

        $editarLivros = $this->livros->editarLivros($livrosDataSourceEditar);

        //Assert
        $this->assertEquals($livrosDataSourceEditar['titulo'], $editarLivros->titulo);
        $this->assertEquals($livrosDataSourceEditar['descricao'], $editarLivros->descricao);
        $this->assertEquals($livrosDataSourceEditar['isbn'], $editarLivros->isbn);
        $this->assertEquals($livrosDataSourceEditar['visibilidade'], $editarLivros->visibilidade);
        $this->assertEquals($livrosDataSourceEditar['genero'], $editarLivros->genero);
        $this->assertEquals($livrosDataSourceEditar['idioma'], $editarLivros->idioma);
        $this->assertEquals($adicionarLivros->users_id, $editarLivros->users_id);
    }
    public function testeMeuPerfilLivrosDoUsuarioQuantidade_RetornaInt(): void
    {
        //Setup
        
        //Execução

        $meuPerfilLivrosDoUsuarioQuantidade = $this->livros->meuPerfilLivrosDoUsuarioQuantidade($this->user->id);

        //Assert
        $this->assertIsInt($meuPerfilLivrosDoUsuarioQuantidade);
    }
}
