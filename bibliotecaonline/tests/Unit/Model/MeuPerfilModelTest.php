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

   public function testGetMeuPerfil_RetornaNull() : void
   {
    //setup
    $id = 0 ;
    //execucao
    $retorno = $this->meuPerfil->getMeuPerfil($id);

    //assert
    $this->assertNull($retorno);

   }
   public function testGetMeuPerfil_RetornaDataSource(): void
   {
        //setup
        $meuPerfil = MeuPerfil::first() ;
        //execucao
        $retorno = $this->meuPerfil->getMeuPerfil($meuPerfil->id);

        //assert
        $this->assertEquals($meuPerfil->id , $retorno->id);
        $this->assertEquals($meuPerfil->introducao , $retorno->introducao);
        $this->assertEquals($meuPerfil->profile_picture , $retorno->profile_picture);
        $this->assertEquals($meuPerfil->users_id , $retorno->users_id);
        $this->assertNotEmpty($retorno->users_nome);
        $this->assertNotNull($retorno->quantidadelivros);


   }
}
