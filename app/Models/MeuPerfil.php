<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MeuPerfil extends Model
{
    use HasFactory;
    protected $table='meuperfil' ;
    protected $fillable = ['introducao' , 'profile_picture' , 'users_id' , 'created_at' , 'updated_at',
            'datanascimento'];
    public function editarMeuPerfil($dados) {

        try{

            $meuPerfilDados = MeuPerfil::where('users_id' , '=' , $dados['users_id'] )->first();
        if( $meuPerfilDados!=null ){
            $meuPerfil = $meuPerfilDados->update([
                'introducao' => $dados['introducao'] ,
                'profile_picture' => $dados['profile_picture'] ,
                'datanascimento' => ($dados['datanascimento']==null )?null :$this->formatarData($dados['datanascimento']) ,
                'updated_at' => now(),

            ]);
            return MeuPerfil::where('users_id' , '=' , $dados['users_id'])->first();
        }else{
            if(User::find($dados['users_id'])){
            $meuPerfil = MeuPerfil::create([
                'introducao' => $dados['introducao'] ,
                'profile_picture' => $dados['profile_picture'] ,
                'users_id' => $dados['users_id'] ,
                'datanascimento' => ($dados['datanascimento']==null )?null :$this->formatarData($dados['datanascimento']) ,
                'created_at' => now(),
            ]);
            return $meuPerfil;
        }else{
            return null;
        }
        }
        }
        catch(Exception $e)
        {
            return $e;
        }

    }
    public function formatarData(string $data):string{
        $arr = explode('/',$data );
        return $arr[2].'-'.$arr[1].'-'.$arr[0];
    }
}
