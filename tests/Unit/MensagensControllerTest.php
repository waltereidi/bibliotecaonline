<?php

namespace Tests\Unit;
use Illuminate\Http\Request;
use Tests\TestCase; 
use App\Http\Controllers\MensagensController;
use App\Http\Requests\Mensagens\DeleteMensagensRequest;
use App\Http\Requests\Mensagens\PostMensagensRequest;
use App\Http\Requests\Mensagens\PutMensagensRequest;
use App\Http\Requests\Mensagens\PutMensagensVisualizadoRequest;
use App\Models\Livros;
use App\Models\Mensagens;
use App\Models\MeuPerfil;
use App\Models\User;

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
        
        $mensagensController = new MensagensController();
        
        //Execução 
        $user = User::where('email' , 'testCase@email.com')->first();
        $livrosDataSource['users_id'] = $user->id ;        

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
        
        $mensagensController = new MensagensController(); 

        //Execução 
        $user = User::where('email' , 'testCase@email.com')->first();
        $livrosDataSource['users_id'] = $user->id ;        

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
        $request = new PostMensagensRequest(['mensagem' => 'testCase' ]);
        $livros = new Livros();
        $livrosDataSource = ['titulo' => 'TestCaseAdicionarMensagens' , 'descricao' => null , 'visibilidade' => 0 , 'isbn' => null ,
        'capalivro' => null , 'editoras_nome' => 'TestCaseAdicionarMensagens' , 
        'autores_nome' => 'TestCaseAdicionarMensagens' , 'genero' =>'Ficção Ciêntifica' , 'idioma' => 'Inglês' ]; 
        
        $mensagensController = new MensagensController(); 

        //Execução 
        $user = User::where('email' , 'testCase@email.com')->first();
        $livrosDataSource['users_id'] = $user->id ;        

        $livro = $livros->adicionarLivros($livrosDataSource);
        $mensagensController->setUsersId($user->id) ;
        $request['livros_id'] = $livro->id ;
        $adicionarMensagem = $mensagensController->adicionarMensagens( $request );
        $dadosAdicionarMensagem = $adicionarMensagem->getData(); 
        $requestEditarMensagem = new PutMensagensRequest([ 'id' => $dadosAdicionarMensagem->id  , 'mensagem' => 'TestCase EditarMensagens']);

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
        
        $mensagensController = new MensagensController(); 

        //Execução 
        $user = User::where('email' , 'testCase@email.com')->first();
        $livrosDataSource['users_id'] = $user->id ;        
        
        $livro = $livros->adicionarLivros($livrosDataSource);
        $mensagensController->setUsersId($user->id) ;
        $request['livros_id'] = $livro->id ;
        $adicionarMensagem = $mensagensController->adicionarMensagens( $request );
        $dadosAdicionarMensagem = $adicionarMensagem->getData(); 
        $requestEditarMensagemVisualizado = new PutMensagensVisualizadoRequest([ 'livros_id' => $dadosAdicionarMensagem->livros_id  ]);
        $editarMensagensVisualizada = $mensagensController->editarMensagensVisualizado($requestEditarMensagemVisualizado); 


        $meuPerfil = MeuPerfil::where('users_id' , '=' , $user->id )->first();

        $mensagensDoLivro = Mensagens::where('livros_id' , '=' , $requestEditarMensagemVisualizado->livros_id)
            ->where('meuperfil_id' , '=' , $meuPerfil->id )
            ->where('visualizado' , '=' , false )->get(); 
        //Assert

        $this->assertEquals( 200 , $editarMensagensVisualizada->getStatusCode() );
        $this->assertTrue( $editarMensagensVisualizada->getData()); 
        $this->assertEquals( 0 ,$mensagensDoLivro->count() );  
    }
}
