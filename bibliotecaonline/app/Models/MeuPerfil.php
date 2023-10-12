<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

    public function getMeuPerfil($id ) : ?object
    {
        return DB::table('meuperfil')
        ->join('users' , 'users.id' , '=' ,'meuperfil.users_id')
        ->leftjoin('livros' , 'livros.users_id' , '=' ,'users.id')
        ->select(
                'meuperfil.id as id',
                'meuperfil.introducao as introducao' ,
                'meuperfil.profile_picture as profile_picture' ,
                'meuperfil.datanascimento as datanascimento' ,
                'meuperfil.users_id as users_id' ,
                'users.name as users_nome'
        )
        ->selectRaw('count(livros.id) over( partition by users.id ) as quantidadelivros')
        ->where('users.id' , '=' , $id)
        ->first();



    }
}
