<?php

namespace Tests\Unit\Request\MeuPerfil;

use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestCase;
use App\Models\User;

class PutMeuPerfilRequestTest extends TestCase
{
    public $user;
    public $dados;

    public function SetUp(): void
    {
        parent::setUp();
        $this->user = User::where('email', '=', 'testCase@email.com')->first();
        Auth::loginUsingId($this->user->id);
        $this->dados = [
            'Authorization' => 'Bearer ' . $this->user->api_token,
            'id' => 0,
            'introducao' => 'testCase Request',
            'datanascimento' => '29/12/1993',
            'profile_picture' => 'www.php.net' ,
        ];

    }
    public function testePutMeuPerfil_semToken_retorna403():void
    {
        //Setup
        $dados = $this->dados;
        $dados['Authorization'] = 'Bearer ';
        //execução
        $dados 


    }
}
