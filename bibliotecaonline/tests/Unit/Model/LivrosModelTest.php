<?php

namespace Tests\Unit\Model;

use App\Http\Requests\MeuPerfil\PostLivrosMeuPerfilRequest;
use Tests\TestCase;
use App\Models\Livros;
use App\Models\MeuPerfil;
use App\Models\User;

class LivrosModelTest extends TestCase
{
    public $livros ;
    public $user ;
    public $dadosBuscaIndice ;
    public $meuPerfil ;

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
        $this->meuPerfil = MeuPerfil::where('users_id' , '=' , $this->user->id)->first() ;
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
    public function testeGetLivro_RetornaLivroDataSource(): void
    {
        //setup
        $livro = Livros::first();

        //execucao
        $getLivro = $this->livros->getLivro($livro->id);
        //assert
        $this->assertIsObject($getLivro);
        $this->assertEquals($getLivro->id, $livro->id);
        $this->assertEquals($getLivro->titulo, $livro->titulo);
        $this->assertEquals($getLivro->descricao, $livro->descricao);
        $this->assertEquals($getLivro->visibilidade, $livro->visibilidade);
        $this->assertEquals($getLivro->isbn, $livro->isbn);
        $this->assertEquals($getLivro->editoras_id, $livro->editoras_id);
        $this->assertEquals($getLivro->autores_id, $livro->autores_id);
        $this->assertEquals($getLivro->capalivro, $livro->capalivro);
        $this->assertEquals($getLivro->genero, $livro->genero);
        $this->assertEquals($getLivro->idioma, $livro->idioma);
        $this->assertEquals($getLivro->urldownload ,$livro->urldownload);
        $this->assertEquals($getLivro->users_id , $livro->users_id);
        $this->assertNotEmpty($getLivro->editoras_nome);
        $this->assertNotEmpty($getLivro->autores_nome);
        $this->assertNotEmpty($getLivro->users_nome);
    }
    public function testeGetLivro_IdInvalido_RetornaNull():void
    {
        //Setup
        $id = 0 ;
        //execucao
        $getLivro = $this->livros->getLivro($id);
        //assert
        $this->assertNull($getLivro);

    }
    public function testPostLivrosMeuPerfil_RetornaDataSource():void
    {
        //Setup
        $dados =['quantidade' => 20 ,
                 'pagina' => 0 ,
                 'meuperfil_id' => $this->meuPerfil->id] ;
        //execucao
        $retorno = $this->livros->postLivrosMeuPerfil($dados);
        $validarChaves = get_object_vars($retorno[0]);
        //assert
        $this->assertIsObject($retorno );
        $this->assertArrayHasKey('id', $validarChaves);
        $this->assertArrayHasKey('titulo', $validarChaves);
        $this->assertArrayHasKey('descricao', $validarChaves);
        $this->assertArrayHasKey('visibilidade', $validarChaves);
        $this->assertArrayHasKey('isbn', $validarChaves);
        $this->assertArrayHasKey('editoras_id', $validarChaves);
        $this->assertArrayHasKey('editoras_nome', $validarChaves);
        $this->assertArrayHasKey('autores_id' , $validarChaves);
        $this->assertArrayHasKey('autores_nome', $validarChaves);
        $this->assertArrayHasKey('capalivro', $validarChaves);
        $this->assertArrayHasKey('genero', $validarChaves);
        $this->assertArrayHasKey('idioma', $validarChaves);
        $this->assertArrayHasKey('urldownload' , $validarChaves);
    }
    public function testPostLivrosMeuPerfil_RetornaNull():void
    {
        //Setup
        $dados =['quantidade' => 20 ,
                 'pagina' => 0 ,
                 'meuperfil_id' => 0] ;
        //Execucao
        $retorno = $this->livros->postLivrosMeuPerfil($dados) ;

        //assert
        $this->assertNull($retorno);

   }
   public function testGetPerfilUsuarioLivros_SemDadosRetornaNull() : void
   {
        //setup
        $users_id = 0 ;
        $offset = 0 ;

        //execucao
        $retorno = $this->livros->getPerfilUsuarioLivros($users_id , $offset );

        //assert
        $this->assertNull($retorno);
   }
   public function testGetPerfilUsuarioLivros_RetornaDataSource() : void
   {
        //Setup
        $users_id = $this->user->id ;
        $offset = 0 ;
        //execucao
        $retorno = $this->livros->getPerfilUsuarioLivros($users_id , $offset );
        $validarChaves = get_object_vars($retorno[0]);
        //assert
        $this->assertTrue(count($retorno)>0 );
        $this->assertTrue(count($retorno)<=6);
        $this->assertIsObject($retorno);
        $this->assertArrayHasKey( 'id' , $validarChaves);
        $this->assertArrayHasKey( 'titulo' , $validarChaves);
        $this->assertArrayHasKey( 'autores_nome' , $validarChaves);
        $this->assertArrayHasKey( 'capalivro' , $validarChaves);




   }
}
