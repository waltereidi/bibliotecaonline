<?php

namespace Tests\Unit;

use App\Models\Livros;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ApiMensagensRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public $user;
    public function setUp() :void {
        parent::setUp(); 
        $this->user = User::where('email' , '=' , 'testCase@email.com')->first(); 
        Auth::loginUsingId($this->user->id);

    }

    public function testeAdicionarMensagens_Retorna401(){
        //Setup
        $dados = ['Authorization' => 'Bearer ' , 
    ];
        //Execução
        $retorno = $this->post('/api/mensagens/adicionarMensagens' , $dados );
        //Assert
        $this->assertEquals(401 , $retorno->getStatusCode()); 
    } 
    public function testeAdicionarMensagens_DadosInvalidos_Retorna302(){
        //Setup
        $dados = ['Authorization' => 'Bearer '.$this->user->api_token , 
            'mensagem' =>'' , 'livros_id' => null , 'meuperfil_id' => null
    ];
        //Execução
        $retorno = $this->post('/api/mensagens/adicionarMensagens' , $dados );
        //Assert
        
        $this->assertEquals(302 , $retorno->getStatusCode()); 
        $retorno->assertSessionHasErrors(['mensagem' => 'Campo obrigatório não preenchido']);
        $retorno->assertSessionHasErrors(['livros_id' => 'Campo obrigatório não preenchido']);
        $retorno->assertSessionHasErrors(['meuperfil_id' => 'Campo obrigatório não preenchido']);
        
    } 
    public function testeEditarMensagens_Retorna401(){
        //Setup    
        $dados = ['Authorization' => 'Bearer ' , 
    ];
        //Execução
        $retorno = $this->put('/api/mensagens/editarMensagens' , $dados ); 

        //Assert 
        $this->assertEquals(401 , $retorno->getStatusCode()); 
    }
    public function testeEditarMensagens_DadosInvalidos_Retorna302(){
        //Setup    
        $dados = ['Authorization' =>'Bearer '.$this->user->api_token , 
        'id' => null , 'mensagem' => ''
    ];
        //Execução
        $retorno = $this->put('/api/mensagens/editarMensagens' , $dados ); 

        //Assert 
        $this->assertEquals(302 , $retorno->getStatusCode());
        $retorno->assertSessionHasErrors(['mensagem' => 'Campo obrigatório não preenchido']);
        $retorno->assertSessionHasErrors(['id' => 'Campo obrigatório não preenchido']);
         
    }
    public function testeEditarMensagensVisualizado_Retorna401(){
        //Setup    
        $dados = ['Authorization' => 'Bearer ' , 
    ];
        //Execução
        $retorno = $this->put('/api/mensagens/editarMensagensVisualizado' ,$dados );
        //Assert 
        $this->assertEquals(401 , $retorno->getStatusCode()); 
    }
    public function testeEditarMensagensVisualizado_DadosInvalidos_Retorna302(){
        //Setup    
        $dados = [ 'Authorization' =>'Bearer '.$this->user->api_token , 
        'livros_id' => null , 'meuperfil_id' => null ];
        //Execução
        $retorno = $this->put('/api/mensagens/editarMensagensVisualizado' ,$dados );
        //Assert 
        $this->assertEquals(302 , $retorno->getStatusCode()); 
        $retorno->assertSessionHasErrors(['livros_id' => 'Campo obrigatório não preenchido']);
        $retorno->assertSessionHasErrors(['meuperfil_id' => 'Campo obrigatório não preenchido']);
         
    }


    public function testeDeletarMensagens_Retorna401(){
        //Setup    
        $dados = ['Authorization' => 'Bearer '  ];
        //Execução
        $retorno = $this->delete('/api/mensagens/deletarMensagens' , $dados ); 
        //Assert 
        $this->assertEquals(401 , $retorno->getStatusCode()); 
    }
    public function testeDeletarMensagens_Retorna302(){
        //Setup    
        $dados = ['Authorization' =>'Bearer '.$this->user->api_token , 
        'id' => null , 'meuperfil_id'=> null , 'meuperfilamigo_id' => null 
    ];
        //Execução
        $retorno = $this->delete('/api/mensagens/deletarMensagens' , $dados ); 
        //Assert 
        $this->assertEquals(302 , $retorno->getStatusCode()); 
        $retorno->assertSessionHasErrors(['id' => 'Campo obrigatório não preenchido']);
        $retorno->assertSessionHasErrors(['meuperfil_id' => 'Campo obrigatório não preenchido']);
        $retorno->assertSessionHasErrors(['meuperfilamigo_id' => 'Campo obrigatório não preenchido']);
         
    }


    public function testeGetMensagensCaixa_Retorna401(){
        //Setup    
        $dados = ['Authorization' => 'Bearer ' , 
    ];
        //Execução
        $retorno = $this->get('/api/mensagens/getMensagensCaixa' ,  $dados );
        //Assert 
        $this->assertEquals(401 , $retorno->getStatusCode());  

    }

    public function testeGetMensagensLivros_Retorna401(){
        //Setup
        $dados = ['Authorization' => 'Bearer ' , 
        ];
        //Execução
        $retorno = $this->post('/api/mensagens/getMensagensLivros',$dados );
        //Assert 
        $this->assertEquals(401 , $retorno->getStatusCode());  

    }
    public function testeGetMensagensLivros_Retorna200(){
        //Setup
        $livro = Livros::where('users_id' , '=' , $this->user->id )->first();
        $dados = ['Authorization' => 'Bearer '.$this->user->api_token , 
        'livros_id' => $livro->id ];
        
        //Execução
        $retorno = $this->post('/api/mensagens/getMensagensLivros',$dados );
        //Assert 
        $this->assertEquals(200 , $retorno->getStatusCode());  

    }
    public function testeGetMensagensLivros_LivrosIdNaoDefinido_Retorna419(){
        //Setup
        $dados = ['Authorization' => 'Bearer '.$this->user->api_token , 
        ];
        
        //Execução
        $retorno = $this->post('/api/mensagens/getMensagensLivros' ,$dados );
        //Assert 
        $this->assertEquals(302 , $retorno->getStatusCode());  

    }
}
