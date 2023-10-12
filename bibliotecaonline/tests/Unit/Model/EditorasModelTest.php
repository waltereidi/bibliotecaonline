<?php

namespace Tests\Unit\Model;

use Illuminate\Support\Facades\DB;
use App\Models\Editoras;

use Tests\TestCase;

class EditorasModelTest extends TestCase
{
    //Setup
    //Execucao
    //Assert
    public $editoras ;
    public function setUp(): void {
        parent::setUp();
        $this->editoras = new Editoras();

    }


    public function testeAdicionarAutorInexistente_retornaEntidade(){

    //Setup
        $nomeEditora = 'TestCase';
    //Execucao
        $editora = $this->editoras->adicionarEditoraInexistente($nomeEditora);
    //Assert

        $this->assertInstanceOf(Editoras::class , $editora );
        $this->assertEquals($editora->nome  , $nomeEditora);
        $this->assertNotEmpty($editora->id);
        $this->assertNotEmpty($editora->updated_at);
        $this->assertNotEmpty($editora->created_at);
    }

}
