<?php

namespace Tests\Unit\Request\MeuPerfil;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
class PutMeuPerfilRequestTest extends TestCase
{
    public $user;
    public $dados;
    public $url ;
    public function SetUp(): void
    {
        parent::setUp();
        $this->user = User::where('email', '=', 'testCase@email.com')->first();
        Auth::loginUsingId($this->user->id);
        $this->url = '/api/meuperfil/putMeuPerfil';
        $this->dados = [
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'id' => 0,
            'users_id'=>0,
            'introducao' => 'testCase Request',
            'datanascimento' => '29/12/1993',
            'profile_picture' => 'http://www.php.net' ,
        ];

    }
    public function testePutMeuPerfil_semToken_retorna401():void
    {
        //Setup
        $dados = $this->dados;
        $dados['Authorization'] = 'Bearer ';
        //execução
        $retorno= $this->put($this->url , $dados );

        //Assert
        $this->assertEquals(401 , $retorno->getStatusCode() );
    }
    public function testePutMeuPerfil_Retorna204():void
    {
        //Setup
        $dados = $this->dados;

        //execucao
        $retorno = $this->put($this->url , $dados);
        //Assert
        $this->assertEquals(204 , $retorno->getStatusCode());
    }
    public function testePutMeuPerfil_DadosNaoPreenchidos_Retorna302():void
    {
        //setup
        $dados= $this->dados;
        unset($dados['id']);
        unset($dados['users_id']);
        //execucao
        $retorno = $this->put($this->url , $dados);
        //assert
        $this->assertEquals($retorno->getStatusCode() , 302);
        $retorno->assertSessionHasErrors('id' , 'Campo obrigatório não preenchido');
        $retorno->assertSessionHasErrors('users_id' , 'Campo obrigatório não preenchido');
    }
    public function testePutMeuPerfil_CaracteresExcedidos_Retorna302():void
    {
        //Setup
        $dados = $this->dados ;
        $dados['introducao'] = Str::random(2049);
        $dados['profile_picture'] = Str::random(2049);

        //Execucao
        $retorno = $this->put($this->url , $dados);
        //assert
        $this->assertEquals($retorno->getStatusCode() , 302 );
        $retorno->assertSessionHasErrors('introducao' ,'Limite de caracteres excedido');
        $retorno->assertSessionHasErrors('profile_picture' ,'Limite de caracteres excedido');

    }
    public function testePutMeuPerfil_UrlInvalida_Retorna302():void
    {
        //Setup
        $dados=$this->dados;
        $dados['profile_picture'] = 'TestCase Request';

        //Execucao
        $retorno =$this->put($this->url , $dados);
        //Assert
        $this->assertEquals($retorno->getStatusCode() , 302);
        $retorno->assertSessionHasErrors('profile_picture' , 'Url inválida');

    }
    public function testePutMeuPerfil_DataInvalida_Retorna302():void
    {
        //Setup
        $dados = $this->dados ;
        $dados['datanascimento'] = 'TestCase';
        //Execucao
        $retorno = $this->put($this->url , $dados);
        //Asssert
        $this->assertEquals($retorno->getStatusCode() , 302);
        $retorno->assertSessionHasErrors('datanascimento' , 'Data inválida');

    }


}
