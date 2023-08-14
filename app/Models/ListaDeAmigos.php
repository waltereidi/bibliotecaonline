<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaDeAmigos extends Model
{
    protected $table= 'listadeamigos';
    protected $fillable = ['meuperfil_id' , 'meuperfilamigo_id' , 'created_at' , 'updated_at'];
    use HasFactory;

    public function getListaDeAmigos($users_id ) : ?object {

        return $this->join('meuperfil as mp' , 'mp.id' , '=' , 'listadeamigos.meuperfil_id') 
        ->join('meuperfil as mpa' , 'mpa.id' , '=' , 'listadeamigos.meuperfilamigo_id')
        ->join('users as ua' , 'ua.id' , '=' , 'mpa.users_id')
        ->where('ua.id' , '=' , $users_id )  
        ->select( 'ua.name as nome' , 'ua.updated_at as ultimologin' , 'mpa.id as meuperfilamigo_id' )
        ->get();
    } 

    public function adicionarListaDeAmigos(array $dados) : ?ListaDeAmigos {

        return $this->create([
            'meuperfil_id' => $dados['meuperfil_id'] , 
            'meuperfilamigo_id' => $dados['meuperfilamigo_id'] , 
            'created_at' => now(), 
        ]);
        

    }
    public function removerListaDeAmigos(array $dados) : bool {
        
        $listaDeAmigos = $this->find($dados['id']);
        return $listaDeAmigos->delete();
    }
   
}