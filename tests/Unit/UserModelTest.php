<?php

namespace Tests\Unit;

use Tests\TestCase; 
use App\Models\User;
use Carbon\Carbon;

class UserModelTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    public function testGerarNovoToken_ModificaToken() : void {
        //Setup 
        $user = new User ; 
        $login = $user->where('email' , '=' , 'testCase@email.com')->first(); 

        //Execução
        $token = $user->gerarNovoToken($login->id) ; 
        //Assert 
        $this->assertNotEmpty($token->api_token ) ; 
        $this->assertEquals( $token->validade_token , Carbon::now()->add(7 , 'day')->toDateString() );
    }
}
