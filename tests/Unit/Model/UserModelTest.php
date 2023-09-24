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

    public function testGerarNovoToken_RetornaTokenComValidade(): void
    {
        //Setup
        $user = new User;
        $login = $user->where('email', '=', 'testCase@email.com')->first();

        //Execução
        $token = $user->gerarNovoToken($login->id);
        //Assert
        $this->assertNotEmpty($token->api_token);
        $this->assertTrue($token->validade_token > Carbon::now());
    }
    public function testGerarNovoToken_ComTokenInvalido_GeraNovoToken(): void
    {
        //Setup
        $user = new User;

        $login = $user->where('email', '=', 'testCase@email.com')->first();
        $tokenAntigo = $login->api_token;
        $login->update(['validade_token' => Carbon::now()->subDays(10)->toDateString()]);

        $login = $user->where('email', '=', 'testCase@email.com')->first();
        //Execução
        $token = $user->gerarNovoToken($login->id);
        //Assert
        $this->assertNotEmpty($token->api_token);
        $this->assertEquals($token->validade_token, Carbon::now()->add(7, 'day')->toDateString());
        $this->assertNotEquals($tokenAntigo, $token->api_token);
    }
    public function testGerarNovoToken_SemToken_GeraNovoToken(): void
    {
        //Setup
        $user = new User;

        $login = $user->where('email', '=', 'testCase@email.com')->first();
        $login->update([
            'validade_token' => null,
            'api_token' => null
        ]);

        //Execução
        $token = $user->gerarNovoToken($login->id);
        //Assert
        $this->assertNotEmpty($token->api_token);
        $this->assertEquals($token->validade_token, Carbon::now()->add(7, 'day')->toDateString());
    }
}
