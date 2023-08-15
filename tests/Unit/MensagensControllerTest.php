<?php

namespace Tests\Unit;

use Tests\TestCase; 
use App\Http\Controllers\MensagensController;
use App\Http\Requests\Mensagens\GetMensagensLivrosRequest;
use App\Http\Requests\Mensagens\DeleteMensagensRequest;
use App\Http\Requests\Mensagens\PostMensagensRequest;
use App\Http\Requests\Mensagens\PutMensagensRequest;
use App\Http\Requests\Mensagens\PutMensagensVisualizadoRequest;
use App\Models\Livros;
use App\Models\Mensagens;
use App\Models\MeuPerfil;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MensagensControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function teste_AdicionarMensagens_RetornaDataSourceJson(): void
    {  
        //Setup 
        $request = new PostMensagensRequest(['mensagem' => 'testCase' ]);
        $livros = new Livros();
        $livrosDataSource = ['titulo' => 'TestCaseAdicionarMensagens' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
        'capalivro' => null , 'editoras_nome' => 'TestCaseAdicionarMensagens' , 
        'autores_nome' => 'TestCaseAdicionarMensagens' , 'genero' =>'Ficção Ciêntifica' , 'idioma' => 'Inglês' ]; 
        $user = User::where('email' , 'testCase@email.com')->first();
        Auth::loginUsingId($user->id , true );
        $mensagensController = new MensagensController();
        $meuPerfil = MeuPerfil::where('users_id' , '=' , $user->id )->first(); 
        //Execução 
        
        
        $livrosDataSource['users_id'] = $user->id ;        
        $livrosDataSource['meuperfil_id'] = $meuPerfil->id ; 
        $livro = $livros->adicionarLivros($livrosDataSource);
        $mensagensController->setUsersId($user->id) ;
        $request['livros_id'] = $livro->id ;
        $adicionarMensagem = $mensagensController->adicionarMensagens( $request );
        //Assert   
        $dadosRetorno = $adicionarMensagem->getData();  
        
        
        $this->AssertEquals( 200 , $adicionarMensagem->getStatusCode());
        $this->AssertEquals( $request->mensagem , $dadosRetorno->mensagem );  
        $this->AssertEquals( $livro->id , $dadosRetorno->livros_id );
        
        
    }
    public function teste_DeletarMensagens_RetornaTrue(): void
    {
        //Setup 
        $request = new PostMensagensRequest(['mensagem' => 'testCase' ]);
        $livros = new Livros();
        $livrosDataSource = ['titulo' => 'TestCaseDeletarMensagens' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
        'capalivro' => null , 'editoras_nome' => 'TestCaseDeletarMensagens' , 
        'autores_nome' => 'TestCaseDeletarMensagens' , 'genero' =>'Ficção Ciêntifica' , 'idioma' => 'Inglês' ]; 
        $user = User::where('email' , 'testCase@email.com')->first();
        Auth::loginUsingId($user->id , true );
        $mensagensController = new MensagensController(); 
        $meuPerfil = MeuPerfil::where( 'users_id' , '=' ,$user->id )->first();
        //Execução 
        
        $livrosDataSource['users_id'] = $user->id ;      
        $livrosDataSource['meuperfil_id'] = $meuPerfil->id ;   

        $livro = $livros->adicionarLivros($livrosDataSource);
        $mensagensController->setUsersId($user->id) ;
        $request['livros_id'] = $livro->id ;
        $adicionarMensagem = $mensagensController->adicionarMensagens( $request );
        $dadosAdicionarMensagem = $adicionarMensagem->getData(); 
        $requestDeletarMensagem = new DeleteMensagensRequest(['id' => $dadosAdicionarMensagem->id]);
        $deletarMensagem = $mensagensController->deletarMensagens($requestDeletarMensagem);

        $retornoDeletarMensagem = $deletarMensagem->getData(); 
        $mensagemDeletada = Mensagens::find($requestDeletarMensagem->id);
        //Assert     
        $this->assertEquals( 200 , $deletarMensagem->getStatusCode()); 
        $this->assertTrue( $retornoDeletarMensagem );
        $this->assertFalse( $mensagemDeletada->visivel );
    }
    public function teste_EditarMensagens_RetornaDataSourceJson(): void
    {
        //Setup 
        
        $livros = new Livros();
        $livrosDataSource = ['titulo' => 'TestCaseAdicionarMensagens' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
        'capalivro' => null , 'editoras_nome' => 'TestCaseAdicionarMensagens' , 
        'autores_nome' => 'TestCaseAdicionarMensagens' , 'genero' =>'Ficção Ciêntifica' , 'idioma' => 'Inglês' ]; 
        $user = User::where('email' , 'testCase@email.com')->first();
        Auth::loginUsingId($user->id , true );
        $mensagensController = new MensagensController(); 
        $meuPerfil = MeuPerfil::where('users_id' ,'=' , $user->id)->first(); 
        //Execução 
        
        $livrosDataSource['users_id'] = $user->id ;        
        //$livrosDataSource['meuperfil_id'] = $meuPerfil->id; 

        $livro = $livros->adicionarLivros($livrosDataSource);
        $mensagensController->setUsersId($user->id) ;
        
        $request = new PostMensagensRequest(['mensagem' => 'testCase'  ,'livros_id' => $livro->id , 'meuperfil_id' => $meuPerfil->id]);
        $adicionarMensagem = $mensagensController->adicionarMensagens( $request );
        $dadosAdicionarMensagem = $adicionarMensagem->getData(); 
        $requestEditarMensagem = new PutMensagensRequest([ 'id' => $dadosAdicionarMensagem->id  , 'mensagem' => 'TestCase EditarMensagens' ,
        'meuperfil_id' => $meuPerfil->id ]);

        $editarMensagem = $mensagensController->editarMensagens($requestEditarMensagem);
        $dadosRetornoEditarMensagem = $editarMensagem->getData();        
        
        //Assert
        
        $this->assertEquals( 200 , $editarMensagem->getStatusCode()); 
        $this->assertEquals( $dadosRetornoEditarMensagem->mensagem , $requestEditarMensagem->mensagem );

    }
    
    public function teste_EditarMensagensVisualizado_RetornaBoolean(): void { 
        //Setup 
        $request = new PostMensagensRequest(['mensagem' => 'testCase' ]);
        $livros = new Livros();
        $livrosDataSource = ['titulo' => 'TestCaseEditarMensagensVisualizado' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
        'capalivro' => null , 'editoras_nome' => 'TestCaseEditarMensagensVisualizado' , 
        'autores_nome' => 'TestCaseEditarMensagensVisualizado' , 'genero' =>'Ficção Ciêntifica' , 'idioma' => 'Inglês' ]; 
        $user = User::where('email' , 'testCase@email.com')->first();
        Auth::loginUsingId($user->id , true );
        $mensagensController = new MensagensController(); 
        $meuPerfil = MeuPerfil::where('users_id' , '=' , $user->id)->first();
        //Execução 
        
        $livrosDataSource['users_id'] = $user->id ;        
        $livrosDataSource['meuperfil_id'] = $meuPerfil->id; 

        $livro = $livros->adicionarLivros($livrosDataSource);
        $mensagensController->setUsersId($user->id) ;
        $request['livros_id' ] = $livro->id ;
        $request['meuperfil_id'] = $livrosDataSource['meuperfil_id']; 

        $adicionarMensagem = $mensagensController->adicionarMensagens( $request );
        $dadosAdicionarMensagem = $adicionarMensagem->getData(); 
        $requestEditarMensagemVisualizado = new PutMensagensVisualizadoRequest([ 'livros_id' => $dadosAdicionarMensagem->livros_id  ]);
        $editarMensagensVisualizada = $mensagensController->editarMensagensVisualizado($requestEditarMensagemVisualizado); 


        //Assert

        $this->assertEquals( 200 , $editarMensagensVisualizada->getStatusCode() );
        $this->assertIsBool( $editarMensagensVisualizada->getData()); 
    }

    public function teste_GetMensagensCaixa_RetornaDataSource() : void {

        //Setup 
        $user = User::where('email' , '=' , 'testCase@email.com')->first();
        Auth::loginUsingId($user->id , true );
        $mensagensController = new MensagensController(); 
        //Execução 

        $getMensagensCaixa = $mensagensController->getMensagensCaixa(); 
        $dados = $getMensagensCaixa->getData(); 
        $validarChaves = get_object_vars($dados[0]);
        //Assert 
        $this->assertEquals( 200 , $getMensagensCaixa->getStatusCode()); 
        $this->assertFalse( empty($dados)  );
        $this->assertIsArray($dados);
        $this->assertArrayHasKey( 'visualizado' , $validarChaves  ); 
        $this->assertArrayHasKey( 'livros_id' , $validarChaves );
        $this->assertArrayHasKey( 'meuperfil_id' , $validarChaves ); 
        $this->assertArrayHasKey( 'autores_id' , $validarChaves ); 
        $this->assertArrayHasKey( 'editoras_id' , $validarChaves ); 
        $this->assertArrayHasKey( 'editoras_nome' , $validarChaves ); 
        $this->assertArrayHasKey( 'autores_nome' , $validarChaves ); 
    }

    public function teste_GetMensagensLivros_RetornaDataSource( ) : void {
        //Setup 
        $user = User::where('email' , '=' , 'testCase@email.com')->first();
        Auth::loginUsingId($user->id , true); 
        $mensagensController = new MensagensController(); 
        
        $livro = Livros::where('users_id' , '=',  $user->id)->first();
        $request = new PostMensagensRequest(['mensagem' => 'testCase' ]);
        $meuPerfil=  MeuPerfil::where('users_id' , '=' ,$user->id )->first();
        $request['livros_id'] = $livro->id ;
        $request['meuperfil_id'] = $meuPerfil->id ; 
        $adicionarMensagem = $mensagensController->adicionarMensagens($request );
        $requestGetMensagensLivros = new GetMensagensLivrosRequest( [
            'livros_id' => $livro->id 
        ] );
        //Execução 
        $getMensagensLivros = $mensagensController->getMensagensLivros($requestGetMensagensLivros);
        $dados = $getMensagensLivros->getData();
        $validarChaves = get_object_vars($dados[0]);

        //Assert 
        $this->assertEquals(200 , $getMensagensLivros->getStatusCode() );
        $this->assertFalse( empty($dados)); 
        $this->assertIsArray($validarChaves);
        $this->assertArrayHasKey( 'mensagem' , $validarChaves);
        $this->assertArrayHasKey( 'created_at' , $validarChaves);
        $this->assertArrayHasKey( 'livros_id' , $validarChaves);
        $this->assertArrayHasKey( 'meuperfil_id' , $validarChaves);
        $this->assertArrayHasKey( 'visualizado' , $validarChaves);

    }
}
