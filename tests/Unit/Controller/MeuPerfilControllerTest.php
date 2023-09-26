<?php

namespace Tests\Unit;

use Illuminate\View\View;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Models\Livros;
use App\Models\User;
use App\Http\Controllers\MeuPerfilController;
use App\Models\MeuPerfil;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MeuPerfil\DeleteLivrosRequest;
use App\Http\Requests\MeuPerfil\PostLivrosRequest;
use App\Http\Requests\MeuPerfil\PutLivrosRequest;
use App\Http\Requests\MeuPerfil\PutMeuPerfilRequest;
use Mockery;
use Mockery\MockInterface;

class MeuPerfilControllerTest extends TestCase
{
    //Setup
    //Execução
    //Assert
    public $dados ;
    public $meuPerfilController;
    public $user ;


    public function setUp():void
    {
        parent::setUp();
        $this->dados =['titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
        'capalivro' => null, 'editoras_nome' => 'TestCase',
        'autores_nome' => 'TestCase', 'genero' => 'Terror', 'idioma' => 'Português/Brasil',
        'urldownload'=>'http://www.php.net'];
        $this->meuPerfilController=new MeuPerfilController;
        $this->user = User::where('email' , '=' ,'testCase@email.com')->first();


    }

    public function testeIndex_SemAutenticacao_RetornaLoginView(): void
    {
        //Setup


        //Execução
        $view = $this->meuPerfilController->index();
        //Assert
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('auth.login', $view->getName());
    }
    public function testeIndex_SemLivros_RetornaViewComDataSourceLivrosNullPerfil(): void
    {

        //Setup

        //Execução
        $this->meuPerfilController->setUsersId(0);
        $view = $this->meuPerfilController->index();
        $viewDataSource = $view->getData();
        //Assert
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('meuperfil', $view->getName());
        $this->assertNotEmpty($viewDataSource);
        $this->assertNull($viewDataSource['dataSourceLivros']);
        $this->assertNull($viewDataSource['dataSourceUsers']);
        $this->assertIsInt($viewDataSource['dataSourceQuantidadeLivros']);
    }
    public function testeAdicionarLivros_RetornaLivrosDataSource(): void
    {
        //Setup
        $livros = Request::create(
            'meuperfil/adicionarLivros',
            'POST',
            [
                'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
                'capalivro' => null, 'editoras_nome' => 'TestCase',
                'autores_nome' => 'TestCase', 'genero' => 'Terror', 'idioma' => 'Português/Brasil',
                'urldownload'=>'http://www.php.net'
            ]
        );

        $user = User::where('email', 'testCase@email.com')->first();

        $this->meuPerfilController->setUsersId($user->id);
        //Execução
        $adicionarLivros = $this->meuPerfilController->adicionarLivros($livros);
        //Assert
        $this->assertInstanceOf(Livros::class, $adicionarLivros);
        $this->assertEquals($livros['titulo'], $adicionarLivros->titulo);
        $this->assertEquals($livros['descricao'], $adicionarLivros->descricao);
        $this->assertEquals($livros['visibilidade'], $adicionarLivros->visibilidade);
        $this->assertEquals($livros['genero'], $adicionarLivros->genero);
        $this->assertEquals($livros['idioma'], $adicionarLivros->idioma);
        $this->assertEquals($livros['urldownload'], $adicionarLivros->urldownload);
        $this->assertNotEmpty($adicionarLivros->autores_id);
        $this->assertNotEmpty($adicionarLivros->editoras_id);
        $this->assertNotEmpty($adicionarLivros->users_id);
    }
    public function testeAdicionarLivros_NaoAutenticado_Retorna401(): void
    {

        //Setup

        $livros = Request::create(
            'meuperfil/adicionarLivros',
            'POST',
            [
                'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
                'capalivro' => null, 'editoras_nome' => 'TestCase',
                'autores_nome' => 'TestCase','urldownload'=>'http://www.php.net'
            ]
        );

        //Execução
        $adicionarLivros = $this->meuPerfilController->adicionarLivros($livros);

        //Assert
        $this->assertStringContainsString('401', $adicionarLivros);
    }
    public function testeAdicionarLivros_RetornaErroDataSourceIncorreto(): void
    {

        //Setup

        $user = User::where('email', 'testCase@email.com')->first();

        $this->meuPerfilController->setUsersId($user->id);
        //Execução
        $this->meuPerfilController->setUsersId(0);
        $livrosRequest = Request::create(
            'meuperfil/adicionarLivros',
            'POST',
            [
                'titulo' => '', 'descricao' => 'TestCaseEditar', 'visibilidade' => 0, 'isbn' => null,
                'capalivro' => null, 'editoras_nome' => 'TestCaseEditar',
                'autores_nome' => 'TestCaseEditar'
            ]
        );
        $adicionarLivros = $this->meuPerfilController->adicionarLivros($livrosRequest);

        //Assert
        $this->assertIsObject($adicionarLivros);
        $this->assertEquals(417, $adicionarLivros->getStatusCode());
    }

    public function testeEditarLivros_RetornaLivrosDataSource(): void
    {
        //Setup

        $livros = Request::create(
            'meuperfil/adicionarLivros',
            'POST',
            [
                'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
                'editoras_nome' => 'TestCase',
                'autores_nome' => 'TestCase',
                'capalivro' => 'https://img.freepik.com/free-psd/book-hardcover-mockup_125540-225.jpg?w=1060&t=st=1691442549~exp=1691443149~hmac=dcdee8ad230673bf52de12265b676387c937a4cf1f04434ed43a26ea2c051d48',
                'urldownload'=>'http://www.php.net'
            ]
        );

        $user = User::where('email', 'testCase@email.com')->first();

        $this->meuPerfilController->setUsersId($user->id);

        //Execucao
        $adicionarLivros = $this->meuPerfilController->adicionarLivros($livros);
        $editarLivrosRequest = Request::create(
            'meuperfil/adicionarLivros',
            'POST',
            [
                'id' => $adicionarLivros->id,
                'titulo' => 'TestCaseEditar', 'descricao' => 'TestCaseEditar', 'visibilidade' => 0, 'isbn' => null,
                'capalivro' => null, 'editoras_nome' => 'TestCaseEditar',
                'autores_nome' => 'TestCaseEditar', 'genero' => 'Ficção Ciêntifica', 'idioma' => 'Português do Brasil',
                'urldownload'=>'http://www.php.net'
            ]
        );
        $editarLivros = $this->meuPerfilController->editarLivros($editarLivrosRequest);
        //Asssert
        $this->assertInstanceOf(Livros::class, $editarLivros);
        $this->assertEquals($editarLivrosRequest['titulo'], $editarLivros->titulo);
        $this->assertEquals($editarLivrosRequest['descricao'], $editarLivros->descricao);
        $this->assertEquals($editarLivrosRequest['visibilidade'], $editarLivros->visibilidade);
        $this->assertEquals($editarLivrosRequest['idioma'], $editarLivros->idioma);
        $this->assertEquals($editarLivrosRequest['genero'], $editarLivros->genero);
        $this->assertNotEmpty($editarLivros->autores_id);
        $this->assertNotEmpty($editarLivros->editoras_id);
        $this->assertNotEmpty($editarLivros->users_id);
    }

    public function testeRemoverLivros_RetornaTrue(): void
    {
        //Setup

        $livros = Request::create(
            'meuperfil/adicionarLivros',
            'POST',
            [
                'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
                'capalivro' => null, 'editoras_nome' => 'TestCase',
                'autores_nome' => 'TestCase','urldownload'=>'http://www.php.net'
            ]
        );

        $user = User::where('email', 'testCase@email.com')->first();
        $this->meuPerfilController->setUsersId($user->id);

        //Execução
        $adicionarLivros = $this->meuPerfilController->adicionarLivros($livros);
        $livro = $this->meuPerfilController->removerLivros($adicionarLivros->id);

        //Assert
        $this->assertTrue($livro);
    }

    public function testeRemoverLivros_RetornaFalse(): void
    {
        //Setup

        $livros = Request::create(
            'meuperfil/adicionarLivros',
            'POST',
            [
                'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
                'capalivro' => null, 'editoras_nome' => 'TestCase',
                'autores_nome' => 'TestCase'
            ]
        );
        $user = User::where('email', 'testCase@email.com')->first();
        $this->meuPerfilController->setUsersId($user->id);

        //Execução
        $livro = $this->meuPerfilController->removerLivros(0);

        //Assert
        $this->assertFalse($livro);
    }
    public function testeGetPaginacao_retornaNull(): void
    {
        //Setup

        $user = User::where('email', 'testCase@email.com')->first();
        $request = Request::create(
            'meuperfil/getPaginacaoLivrosDoUsuario',
            'POST',
            ['users_id' => $user->id, 'paginacao' => 99999]
        );
        //Execução
        $livrosDoUsuarioPaginacao = $this->meuPerfilController->getPaginacaoLivrosDoUsuario($request);

        //Assert
        $this->assertNull($livrosDoUsuarioPaginacao);
    }

    public function testeValidarLivrosRequest_UrlInvalida_retornaErro(): void
    {
        //Setup

        $livros = Request::create(
            'meuperfil/adicionarLivros',
            'POST',
            [
                'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
                'editoras_nome' => 'TestCase',
                'autores_nome' => 'TestCase',
                'capalivro' => 'testeURLInvalida',
                'urldownload'=>'testeURLInvalida'
            ]
        );
        $this->meuPerfilController->setUsersId(0);
        //Execução
        $validator = $this->meuPerfilController->validarLivrosRequest($livros);
        $dados = $validator['dados'];
        $validador = $validator['validador'];
        //Assert
        $this->assertTrue($validador->fails());
        $this->assertNotEmpty($dados);
    }
    public function testeValidarLivrosRequest_UrlInvalida_retornaTrue(): void
    {
        //Setup

        $livros = Request::create(
            'meuperfil/adicionarLivros',
            'POST',
            [
                'titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
                'editoras_nome' => 'TestCase',
                'autores_nome' => 'TestCase',
                'capalivro' => 'sdsd',
                'urldownload'=>'sdsds'
            ]
        );
        $this->meuPerfilController->setUsersId(0);

        //Execução
        $validator = $this->meuPerfilController->validarLivrosRequest($livros);
        $dados = $validator['dados'];
        $validador = $validator['validador'];
        //Assert
        $this->assertTrue($validador->fails());
        $this->assertNotEmpty($dados);
    }
    public function testeEditarMeuPerfil_RetornaDataSource(): void
    {
        //Setup

        $user = User::where('email', '=', 'testCase@email.com')->first();
        $requestEditarMeuPerfil = Request::create(
            'meuperfil/editarMeuPerfil',
            'POST',
            [
                'profile_picture' => 'https://img.freepik.com/free-psd/book-hardcover-mockup_125540-225.jpg?w=1060&t=st=1691442549~exp=1691443149~hmac=dcdee8ad230673bf52de12265b676387c937a4cf1f04434ed43a26ea2c051d48',
                'introducao' => 'TestCase',
                'datanascimento' => Carbon::createfromDate(1993, 12, 29)->toDateString()
            ]
        );
        //Execução

        $this->meuPerfilController->setUsersId($user->id);

        $editarMeuPerfil = $this->meuPerfilController->editarMeuPerfil($requestEditarMeuPerfil);

        //Assert
        $this->assertInstanceOf(MeuPerfil::class, $editarMeuPerfil);
        $this->assertEquals($editarMeuPerfil->profile_picture, $requestEditarMeuPerfil->profile_picture);
        $this->assertEquals($editarMeuPerfil->introducao, $requestEditarMeuPerfil->introducao);
        $this->assertEquals(
            Carbon::parse($editarMeuPerfil->datanascimento)->locale('pt_BR')->toDateString(),
            Carbon::parse($requestEditarMeuPerfil->datanascimento)->locale('pt_BR')->toDateString()
        );
    }
    public function testeEditarMeuPerfil_RetornaMensagemDeErro(): void
    {
        //Setup

        $user = User::where('email', '=', 'testCase@email.com')->first();
        $requestEditarMeuPerfil = Request::create(
            'meuperfil/editarMeuPerfil',
            'POST',
            [
                'profile_picture' => 'URL',
                'introducao' => 'TestCase'
            ]
        );

        //Execução
        $this->meuPerfilController->setUsersId($user->id);
        $editarMeuPerfil = $this->meuPerfilController->editarMeuPerfil($requestEditarMeuPerfil);
        //Assert
        $this->assertEquals(417, $editarMeuPerfil->getStatusCode());
    }
    public function testeValidarMeuPerfilRequest_RetornaErroValidacao(): void
    {
        //Setup

        $user = User::where('email', '=', 'testCase@email.com')->first();
        $requestEditarMeuPerfil = Request::create(
            'meuperfil/editarMeuPerfil',
            'POST',
            [
                'profile_picture' => 'URL',
                'introducao' => 'TestCase',
                'datanascimento' => Carbon::createFromDate(1993, 12, 29)->toDateString()
            ]
        );
        //Execução
        $this->meuPerfilController->setUsersId($user->id);
        $validarMeuPerfilRequest = $this->meuPerfilController->validarMeuPerfilRequest($requestEditarMeuPerfil);
        $validador = $validarMeuPerfilRequest['validador'];
        $dados = $validarMeuPerfilRequest['dados'];

        //Assert
        $this->assertTrue($validador->fails());
        $this->assertNotEmpty($dados);
        $this->assertEquals($dados['users_id'], $user->id);
        $this->assertEquals($dados['datanascimento'], $requestEditarMeuPerfil->datanascimento);
    }
    public function testeValidarMeuPerfilRequest_RetornaSucesso(): void
    {
        //Setup

        $user = User::where('email', '=', 'testCase@email.com')->first();
        $requestEditarMeuPerfil = Request::create(
            'meuperfil/editarMeuPerfil',
            'POST',
            [
                'profile_picture' => 'https://img.freepik.com/free-psd/book-hardcover-mockup_125540-225.jpg?w=1060&t=st=1691442549~exp=1691443149~hmac=dcdee8ad230673bf52de12265b676387c937a4cf1f04434ed43a26ea2c051d48',
                'introducao' => 'TestCase',
                'datanascimento' => Carbon::createFromDate(1993, 12, 29)->toDateString()
            ]
        );

        //Execução
        $this->meuPerfilController->setUsersId($user->id);
        $validarMeuPerfilRequest = $this->meuPerfilController->validarMeuPerfilRequest($requestEditarMeuPerfil);
        $validador = $validarMeuPerfilRequest['validador'];
        $dados = $validarMeuPerfilRequest['dados'];

        //Assert
        $this->assertFalse($validador->fails());
        $this->assertNotEmpty($dados);
        $this->assertEquals($dados['users_id'], $user->id);
        $this->assertEquals($dados['profile_picture'], $requestEditarMeuPerfil->profile_picture);
        $this->assertEquals($dados['datanascimento'], $requestEditarMeuPerfil->datanascimento);
    }
    public function testeGetDadosMeuPerfil_Retorna200eDataSource()
    {
        //Setup
        $user = User::where('email', '=', 'testCase@email.com')->first();
        Auth::loginUsingId($user->id);
        //Execução

        $meuPerfil = $this->meuPerfilController->getDadosMeuPerfil();
        $meuPerfilDataSource = $meuPerfil->getData();
        //Assert
        $this->assertEquals(200, $meuPerfil->getStatusCode());

        $validarChaves = get_object_vars($meuPerfilDataSource);
        //Assert
        $this->assertFalse(empty($meuPerfil));
        $this->assertIsObject($meuPerfilDataSource);
        $this->assertArrayHasKey('id', $validarChaves);
        $this->assertArrayHasKey('users_id', $validarChaves);
        $this->assertArrayHasKey('profile_picture', $validarChaves);
        $this->assertArrayHasKey('datanascimento', $validarChaves);
        $this->assertArrayHasKey('introducao', $validarChaves);
        $this->assertArrayHasKey('updated_at', $validarChaves);
        $this->assertArrayHasKey('created_at', $validarChaves);
    }

    public function testDeleteLivros_LivroNaoEncontrado_Retorna204(): void
    {
        //setup
        $deleteLivrosRequest = new DeleteLivrosRequest([
            'id'=>0
        ]);
        //execucao
        $retorno = $this->meuPerfilController->deleteLivros($deleteLivrosRequest);

        //assert
        $this->assertEquals(204 , $retorno->getStatusCode());
    }
    public function testDeleteLivros_LivroDeletado_Retorna200():void
    {
        //setup
        $livro = Livros::first();
        $deleteLivrosRequest = new DeleteLivrosRequest([
            'id' => $livro->id
        ]);
        //execucao
        $retorno = $this->meuPerfilController->deleteLivros($deleteLivrosRequest);
        //assert
        $this->assertEquals(200  , $retorno->getStatusCode());
    }

    public function testPostLivros_insertRealizado_Retorna200()
    {
        //setup
        $postLivrosRequest = new PostLivrosRequest([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'users_id' => 1,
            'titulo' => 'TestCase Request',
            'descricao' => 'TestCase Request',
            'visibilidade' => 1,
            'isbn' => 'TestCase',
            'editoras_nome' => 'TestCase Request',
            'autores_nome' => 'TestCase Request',
            'capalivro' => null,
            'genero' => null,
            'idioma' => null,
            'urldownload' => 'https://www.php.net/'
        ]);

        //execucao
        $retorno = $this->meuPerfilController->postLivros($postLivrosRequest);

        //assert
        $this->assertEquals(201 , $retorno->getStatusCode() );

    }
    public function testPostLivros_mockSituacaoErro_Retorna226()
    {
        //setup
        $postLivrosRequest = new PostLivrosRequest([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'users_id' => 1,
            'titulo' => 'TestCase Request',
            'descricao' => 'TestCase Request',
            'visibilidade' => 1,
            'isbn' => 'TestCase',
            'editoras_nome' => 'TestCase Request',
            'autores_nome' => 'TestCase Request',
            'capalivro' => null,
            'genero' => null,
            'idioma' => null,
            'urldownload' => 'https://www.php.net/'
        ]);
        $dados = $postLivrosRequest->all();

        // Defina o comportamento esperado para o método indirectFunction()
        $this->mock(Livros::class , function(MockInterface $mock){
            $mock->shouldReceive('adicionarLivros')->andReturn(null);
        });
        //execucao
        $retorno = $this->meuPerfilController->postLivros($postLivrosRequest);

        //assert
        $this->assertEquals(500 , $retorno->getStatusCode());

    }
}
