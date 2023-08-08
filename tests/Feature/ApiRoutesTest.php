<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Session;

class ApiRoutesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testeGetPaginacaoLivrosDoUsuario_Retorna200()
    {   //Setup 
        Session::start();
        $token = Session::token();
        $user = User::where('email' , '=' , 'testCase@email.com')->first();
        $dados = ['paginacao' => 0 , 'crsf_token' => $token , 'users_id'=>$user->id ,'X-CSRF-TOKEN' => $token ];
        $retorno = $this->post('/api/meuperfil/getPaginacaoLivrosDoUsuario' , $dados );
        $retorno->assertStatus(202);

    }
}
