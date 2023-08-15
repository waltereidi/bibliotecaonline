<?php

namespace Tests\Unit;

use App\Models\MeuPerfil;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class MeuPerfilModelTest extends TestCase
{
    /**
     * A basic feature test example.
     */
   public function testeEditarMeuPerfil_RetornaDataSource(){
    //Setup 
    $meuPerfil = new MeuPerfil;
    $user = User::where('email' , '=' , 'testCase@email.com')->first(); 
    $dados = ['introducao' => '' , 'profile_picture' => null , 
            'datanascimento' => Carbon::createFromDate(1993 , 12 , 29 )->toDateString() , 
            'users_id' => $user->id ];
    
    //Execução 
    $editarMeuPerfil = $meuPerfil->editarMeuPerfil($dados); 
    //Assert 

    $this->assertInstanceOf(MeuPerfil::class , $editarMeuPerfil);
    $this->assertEquals( $dados['datanascimento'] ,  $editarMeuPerfil->datanascimento);
    
   }
}
