<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Autores extends Model
{
    use HasFactory;
    protected $table = 'autores'; 
    protected $fillable = ['nome' , 'created_at' , 'updated_at'];
    
    public function adicionarAutorInexistente( String $nome ) : Autores {
        $autor = Autores::whereRaw("(nome <-> ? ) = 0 " , $nome )->first(); 
        if( $autor == null ){
            $createAutor = ['nome' => $nome , 'created_at' => now()];
            return Autores::create($createAutor);
        }else{
            return $autor; 
        }
    }
}
