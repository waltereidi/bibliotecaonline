<?php

namespace Tests\Request\Feature;

use App\Http\Requests\ListaDeAmigos\DeleteListaDeAmigosRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;

class DeleteListaDeAmigosRequestTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testeDeleteListaDeAmigosRequest_RetornaErro(): void
    {
        //Setup 
        $deleteListaDeAmigosRequest = new DeleteListaDeAmigosRequest([
            'meuperfil_id' => '1' ,
            
        ]);       
        
        dd($deleteListaDeAmigosRequest->validated());
        

        //Assert 
    }

    public function testeDeleteListaDeAmigosRequest_RetornaSucesso(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
