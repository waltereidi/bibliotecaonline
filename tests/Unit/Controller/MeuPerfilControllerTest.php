<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\MeuPerfilController;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MeuPerfil\DeleteLivrosRequest;
use App\Http\Requests\MeuPerfil\PostLivrosRequest;
use App\Http\Requests\MeuPerfil\PutLivrosRequest;
use App\Http\Requests\MeuPerfil\PutMeuPerfilRequest;
use App\Models\MeuPerfil;
use App\Models\Aplicativo;
use App\Models\Livros;
use App\Models\User;

class MeuPerfilControllerTest extends TestCase
{
    //Setup
    //Execução
    //Assert
    public $dados ;
    public $meuPerfilController;
    public $user ;
    public $meuPerfil ;
    public $aplicativo ;

    public function setUp():void
    {
        parent::setUp();
        $this->dados =['titulo' => 'TestCase', 'descricao' => null, 'visibilidade' => 0, 'isbn' => null,
        'capalivro' => null, 'editoras_nome' => 'TestCase',
        'autores_nome' => 'TestCase', 'genero' => 'Terror', 'idioma' => 'Português/Brasil',
        'urldownload'=>'http://www.php.net'];
        $this->meuPerfilController=new MeuPerfilController;
        $this->user = User::where('email' , '=' ,'testCase@email.com')->first();
        $this->meuPerfil = MeuPerfil::where('users_id' ,'=' ,$this->user->id)->first();
        $this->aplicativo = Aplicativo::where('nome' ,'=' ,'bibliotecaonline')->first();
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
        Auth::loginUsingId($this->user->id);
        //Execução

        $this->meuPerfilController->setUsersId($this->meuPerfil->users_id);
        $view = $this->meuPerfilController->index();
        $viewDataSource = $view->getData();
        //Assert
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('meuperfil', $view->getName());
        $this->assertNotEmpty($viewDataSource);
        $this->assertNotEmpty($viewDataSource['datasourcelivros']);
        $this->assertNotEmpty($viewDataSource['datasourcemeuperfil']);
        $this->assertIsInt($viewDataSource['quantidadelivros']);
        $this->assertTrue($viewDataSource['datasourcemeuperfil']->id > 0);
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
                'datanascimento' =>'29/12/1993'
            ]
        );
        //Execução

        $this->meuPerfilController->setUsersId($user->id);

        $editarMeuPerfil = $this->meuPerfilController->editarMeuPerfil($requestEditarMeuPerfil);
        //Assert
        $this->assertEquals($editarMeuPerfil->profile_picture, $requestEditarMeuPerfil->profile_picture);
        $this->assertEquals($editarMeuPerfil->introducao, $requestEditarMeuPerfil->introducao);
        $this->assertEquals( '1993-12-29',$editarMeuPerfil->datanascimento );
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
                'datanascimento' => '29/12/1993'
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
    public function testeGetDadosMeuPerfil_Retorna200eDataSource() : void
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
        $id = 1;
        $authorization = 'Bearer ';
        //execucao
        $retorno = $this->meuPerfilController->deleteLivros($authorization , $id);

        //assert
        $this->assertEquals(204 , $retorno->getStatusCode());
    }


    public function testPostLivros_insertRealizado_Retorna200() :void
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
    public function testPostLivros_insertNaoRealizado_Retorna500() : void
    {
        //setup
        $postLivrosRequest = new PostLivrosRequest([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'users_id' => 0,
            'titulo' => 'TestCase Request Post Erro',
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
        $this->assertEquals(500 , $retorno->getStatusCode() );

    }
    public function testPutLivros_editRealizado_Retorna200():void
    {
        //setup
        $livro = Livros::first();
        $putLivrosRequest = new PutLivrosRequest([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'id' => $livro->id ,
            'users_id' => $livro->users_id,
            'titulo' => 'TestCase PutRequest',
            'descricao' => 'TestCase PutRequest',
            'visibilidade' => 1,
            'isbn' => 'TestCase',
            'editoras_nome' => 'TestCase PutRequest',
            'autores_nome' => 'TestCase PutRequest',
            'capalivro' => null,
            'genero' => null,
            'idioma' => null,
            'urldownload' => 'https://www.php.net/'
        ]);
        //execucao
        $retorno = $this->meuPerfilController->putLivros($putLivrosRequest);

        //assert
        $this->assertEquals(200 , $retorno->getStatusCode());

    }

    public function testPutLivros_editNaoRealizado_Retorna204():void
    {
        //setup
        $putLivrosRequest = new PutLivrosRequest([
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'id' => 0,
            'users_id' => 0,
            'titulo' => 'TestCase PutRequest',
            'descricao' => 'TestCase PutRequest',
            'visibilidade' => 1,
            'isbn' => 'TestCase',
            'editoras_nome' => 'TestCase PutRequest',
            'autores_nome' => 'TestCase PutRequest',
            'capalivro' => null,
            'genero' => null,
            'idioma' => null,
            'urldownload' => 'https://www.php.net/'
        ]);
        //execucao
        $retorno = $this->meuPerfilController->putLivros($putLivrosRequest);
        //assert
        $this->assertEquals(204 , $retorno->getStatusCode() );

    }
    public function testputMeuPerfil_EditarRealizado_Retorna200():void
    {
        //setup

        $putMeuPerfilRequest = new PutMeuPerfilRequest(
            [
                'Authorization' => 'Bearer ' . $this->user->api_token,
                'users_id' => $this->meuPerfil->users_id ,
                'id' => $this->meuPerfil->id ,
                'introducao' => 'testCase EditarRealizadoRequest',
                'datanascimento' => '29/12/1993',
                'profile_picture' => 'http://www.php.net' ,
            ]
            );
        //execucao
        $retorno = $this->meuPerfilController->putMeuPerfil($putMeuPerfilRequest);
        //assert
        $this->assertEquals(200 , $retorno->getStatusCode());
    }
    public function testGetMeuPerfil_RetornaViePaginainicialComToken(){
        //setup

        $view = $this->meuPerfilController->getMeuPerfil(0);
        $viewDataSource = $view->getData();

        $this->assertInstanceOf(View::class , $view );
        $this->assertEquals('paginainicial' , $view->getName() );
        $this->assertEquals($viewDataSource['token_aplicativo'] ,$this->aplicativo->token_aplicacao);



    }
    public function testGetMeuPerfil_RetornaViewComLivro() :void
    {
        //setup
        $meuPerfil = MeuPerfil::first();

        $view = $this->meuPerfilController->getMeuPerfil($meuPerfil->id);
        $viewDataSource = $view->getData();

        $this->assertInstanceOf(View::class , $view );
        $this->assertEquals('perfilusuario' , $view->getName() );
        $this->assertNotEmpty($viewDataSource['meuperfil']);


    }

}
