<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Livros;
use App\Models\Aplicativo;
class LivrosController extends Controller
{
    public $livrosModel ;
    public $aplicativo ;
    public function __construct(){
        $this->livrosModel = new Livros;
        $this->aplicativo = Aplicativo::where('nome' ,'=' ,'bibliotecaonline')->first();

    }

    public function getLivro(int $id)
    {   $livro = $this->livrosModel->getLivro($id);
        if($livro->id){

            return view('livros')->with('livro', $livro);
        }
        else{
        return view('paginainicial')->with('token_aplicativo',$this->aplicativo->token_aplicacao );
        }
    }
}
