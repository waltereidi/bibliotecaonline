<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeuPerfil extends Model
{
    use HasFactory;
    protected $table='meuperfil' ; 
    protected $fillable = ['introducao' , 'profile_picture' , 'users_id' , 'created_at' , 'updated_at'];
    public function editarMeuPerfil($dados) : ?MeuPerfil{
        
        $meuPerfilDados = MeuPerfil::where('users_id' , '=' , $dados['users_id'] )->first();
        if($meuPerfilDados != null ){
            $meuPerfil = $meuPerfilDados->update([
                'introducao' => $dados['introducao'] , 
                'profile_picture' => $dados['profile_picture'] , 
                'updated_at' => now(),
            ]); 
        }else{
            $meuPerfil = MeuPerfil::create([
                'introducao' => $dados['introducao'] , 
                'profile_picture' => $dados['profile_picture'] , 
                'users_id' => $dados['users_id'] ,
                'created_at' => now(),
            ]);
        }
        if($meuPerfil){
            return MeuPerfil::where('users_id' , '=' , $dados['users_id'])->first(); 
        }else{
            return null;
        }

    }    
}
