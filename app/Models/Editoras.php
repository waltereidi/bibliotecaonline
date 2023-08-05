<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editoras extends Model
{
    use HasFactory;
    protected $table = 'editoras';
    protected $fillable = ['nome'];

    public function adicionarEditoraInexistente($nome) : Editoras {

        $editora = Editoras::whereRaw(" ( nome <-> ? ) = 0 " , $nome )->first(); 
        if($editora === null ){

            $createEditora = ['nome' => $nome ];
            return Editoras::create($createEditora);

        }else{
            return $editora ; 
        }
    }
}
