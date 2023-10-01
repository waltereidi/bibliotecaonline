<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    {
        if($id > 0 ){
            $livro = $this->livrosModel->getLivro($id);
            return view('livros')->with('livro', $livro);
        }
        else{
        return view('paginainicial')->with('token_aplicativo',$this->aplicativo->token_aplicacao );
        }
    }
}
