<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\PaginaInicialController; 
use Illuminate\View\View; 


class PaginaInicialTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testeIndexRetornaView(){

        $PaginaInicial = new PaginaInicialController(); 
        $view = $PaginaInicial->index(); 
        
        $this->assertInstanceOf(View::class , $view );
        $this->assertEquals('paginainicial' , $view->getName() );

    }
}
