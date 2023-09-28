<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use App\Models\Livros;
use App\Models\User;

class LivrosModelTest extends TestCase
{
    public $livros ;
    public $user ;
    public $dadosBuscaIndice ;

    public function setUp():void
    {
        parent::setUp();
        $this->livros = new Livros() ;
        $this->user = User::where('email' , 'testCase@email.com')->first();
        $this->dadosBuscaIndice= [
            'quantidade'=>10 ,
            'iniciopagina'=>0,
            'busca'=>[['indice'=>'testCase' , 'tipo'=>'testCase'],
            ['indice'=>'testCase2' , 'tipo'=>'testCase']] ];
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
            'autores_nome' => 'TestCase','urldownload'=>'http://www.php.net'
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
        $this->assertArrayHasKey('urldownload', $validarChaves);
    }
    public function testeAdicionarLivros_RetornaDataSource(): void
    {
        //SetUp
        $livros = new Livros();
        $livrosDataSource = [
            'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
            'capalivro' => null, 'editoras_nome' => 'TestCase',
            'autores_nome' => 'TestCase', 'genero' => 'Ficção Ciêntifica', 'idioma' => 'Inglês',
            'urldownload'=>'http://www.php.net'
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
        $this->assertEquals($livrosDataSource['urldownload'], $adicionarLivros->urldownload);
    }

    public function testeEditarLivros(): void
    {
        //Setup
        $livros = new Livros();


        $livrosDataSource = [
            'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
            'capalivro' => null, 'editoras_nome' => 'TestCase',
            'autores_nome' => 'TestCase',
            'users_id' => $this->user->id,
            'urldownload'=>'http://www.php.net'
        ];
        //Execução

        $adicionarLivros = $this->livros->adicionarLivros($livrosDataSource);
        $livrosDataSourceEditar = [
            'titulo' => 'TestCase Editar Model', 'descricao' => 'TestCase Editar Model', 'visibilidade' => 0, 'isbn' => null,
            'capalivro' => null, 'editoras_nome' => 'TestCase Editar Model',
            'autores_nome' => 'TestCase Editar Model', 'genero' => 'Românce', 'idioma' => 'Inglês',
            'id' => $adicionarLivros->id, 'urldownload'=>'http://www.php.net'
        ];

        $editarLivros = $this->livros->editarLivros($livrosDataSourceEditar);

        //Assert
        $this->assertEquals($livrosDataSourceEditar['titulo'], $editarLivros->titulo);
        $this->assertEquals($livrosDataSourceEditar['descricao'], $editarLivros->descricao);
        $this->assertEquals($livrosDataSourceEditar['isbn'], $editarLivros->isbn);
        $this->assertEquals($livrosDataSourceEditar['visibilidade'], $editarLivros->visibilidade);
        $this->assertEquals($livrosDataSourceEditar['genero'], $editarLivros->genero);
        $this->assertEquals($livrosDataSourceEditar['idioma'], $editarLivros->idioma);
        $this->assertEquals($livrosDataSourceEditar['urldownload'], $editarLivros->urldownload);
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
    public function testeMeuPerfil_postBuscaIndice_RetornaDataSourceVazio():void
    {
        //Setup

        //execucao
        $retorno = $this->livros->postBuscaIndice($this->dadosBuscaIndice['quantidade'] , $this->dadosBuscaIndice['iniciopagina'] , $this->dadosBuscaIndice['busca']);

        //assert
        $this->assertEmpty($retorno['livros']);
        $this->assertEquals($retorno['quantidadeTotal'] , 0);
    }
    public function testePaginainicial_postBuscaIndice_RetornaBuscaComLivros():void
    {
        //Setup
        $dadosBuscaIndice =  $this->dadosBuscaIndice;
        $dadosBuscaIndice['busca'] = [['indice'=> 'Todos' ,'tipo'=>'todos' ]];
        //Execucao

        $livrosBuscaIndice =$this->livros->postBuscaIndice($dadosBuscaIndice['quantidade'] , $dadosBuscaIndice['iniciopagina'] , $dadosBuscaIndice['busca']);
        $validarChaves = get_object_vars($livrosBuscaIndice['livros'][0]);
        //Assert
        $this->assertNotEmpty($livrosBuscaIndice);
        $this->assertIsArray($livrosBuscaIndice);
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
        $this->assertArrayHasKey('urldownload' , $validarChaves);
        $this->assertTrue(count($livrosBuscaIndice['livros']) <= $dadosBuscaIndice['quantidade']);
        $this->assertTrue($livrosBuscaIndice['quantidadeTotal'] > 0 );
    }
    public function testePaginainicial_postBuscaIndice_TesteVariosIndices_RetornaBuscaComLivros():void
    {
        //Setup
        $dadosBuscaIndice =  $this->dadosBuscaIndice;
        $dadosBuscaIndice['busca'] = [['indice'=> 'TestCase' ,'tipo'=>'editoras' ], ['indice'=>'TestCase' , 'tipo' => 'genero']];
        //Execucao

        $livrosBuscaIndice =$this->livros->postBuscaIndice($dadosBuscaIndice['quantidade'] , $dadosBuscaIndice['iniciopagina'] , $dadosBuscaIndice['busca']);
        $validarChaves = get_object_vars($livrosBuscaIndice['livros'][0]);
        //Assert
        $this->assertNotEmpty($livrosBuscaIndice);
        $this->assertIsArray($livrosBuscaIndice);
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
        $this->assertArrayHasKey('urldownload' , $validarChaves);
        $this->assertTrue(count($livrosBuscaIndice['livros']) <= $dadosBuscaIndice['quantidade']);
        $this->assertTrue($livrosBuscaIndice['quantidadeTotal'] > 0 );
    }

    public function testePaginainicial_getIndices_retornaIndices():void
    {
        //setup
        $indices = $this->livros->getIndices();
        //execucao
        $validarChaves = get_object_vars($indices[0]);
        $notNull = true;
        for( $i = 0 ; count($indices) < $i ; $i++)
        {
            if($indices[$i]->indice == null || $indices[$i]->quantidade == null )
            {
                $notNull=false ;
            }

        }
        //asserts
        $this->assertNotEmpty($indices);
        $this->assertIsObject($indices);
        $this->assertArrayHasKey('quantidade' , $validarChaves);
        $this->assertArrayHasKey('tipo' , $validarChaves);
        $this->assertArrayHasKey('indice' , $validarChaves);
        $this->assertTrue($notNull);
    }
    public function testePaginainicial_postBusca_retornaDataSource():void
    {
        //setup
        $busca = 'testCase';
        //execucao
        $postBusca = $this->livros->postBusca($busca);
        $validarChaves = get_object_vars($postBusca['livros'][0]);
        //asserts
        $this->assertNotEmpty($postBusca);
        $this->assertIsArray($postBusca);
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
        $this->assertArrayHasKey('urldownload' , $validarChaves);
        $this->assertTrue($postBusca['quantidadeTotal'] > 0 );
    }

}
