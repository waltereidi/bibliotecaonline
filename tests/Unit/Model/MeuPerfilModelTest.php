<?php

namespace Tests\Unit\Model;

use App\Models\MeuPerfil;
use App\Models\User;
use Tests\TestCase;

class MeuPerfilModelTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected $meuPerfil ;
    public function SetUp():void
    {
        parent::SetUp();
        $this->meuPerfil = new MeuPerfil;
    }
   public function testeEditarMeuPerfil_RetornaDataSource(): void
   {
    //Setup

    $user = User::where('email' , '=' , 'testCase@email.com')->first();
    $dados = ['introducao' => '' , 'profile_picture' => null ,
            'datanascimento' => '29/12/1993' ,
            'users_id' => $user->id ];

    //Execução
    $editarMeuPerfil = $this->meuPerfil->editarMeuPerfil($dados);
    //Assert
    $this->assertEquals( '1993-12-29' , $editarMeuPerfil->datanascimento);

   }
   public function testEditarMeuPerfil_FormatarData():void
   {
    //setup
    $data = '29/12/1993';
    //execucao
    $retorno = $this->meuPerfil->formatarData($data);
    //assert
    $this->assertEquals($retorno , '1993-12-29');
   }
}
