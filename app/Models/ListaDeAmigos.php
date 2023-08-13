<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaDeAmigos extends Model
{
    use HasFactory;

    public function listaDeAmigos($users_id ) : ?object {

        return $this->join('meuperfil as mp' , 'mp.id' , '=' , 'listadeamigos.meuperfil_id') 
        ->join('meuperfil as mpa' , 'mpa.id' , '=' , 'listadeamigos.meuperfilamigo_id')
        ->join('users as ua' , 'ua.id' , '=' , 'mpa.users_id')
        ->where('ua.id' , '=' , $users_id )  
        ->select( 'ua.nome as nome' , 'ua.updated_at as ultimologin' , 'mpa.id as meuperfilamigo_id' )
        ->get();
    } 
}
