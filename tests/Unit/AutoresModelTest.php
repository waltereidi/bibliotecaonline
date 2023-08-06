<?php

namespace Tests\Feature;

use App\Models\Autores;
use Illuminate\Support\Facades\DB;
 
use Tests\TestCase;

class AutoresModelTest extends TestCase
{
    //Setup 
    //Execucao
    //Assert
    public $autores ;
    public function setUp(): void {
        parent::setUp();
        $this->autores = new Autores();

    }

    public function testeAdicionarAutorInexistente_retornaEntidade(){
        
    //Setup 
        DB::beginTransaction();
        $nomeAutor = 'TestCase';
    //Execucao
        $autor = $this->autores->adicionarAutorInexistente($nomeAutor);
    //Assert

        $this->assertInstanceOf(Autores::class , $autor );
        $this->assertNotEmpty($autor->id);
        $this->assertNotEmpty($autor->updated_at);
        $this->assertNotEmpty($autor->created_at);
        $this->assertEquals($autor->nome  , $nomeAutor);
        DB::rollBack();
    }

}
