<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon; 

class Mensagens extends Model
{
    use HasFactory;
    protected $table= 'mensagens';
    protected $fillable = ['mensagem' , 'meuperfil_id' , 'livros_id' , 'visualizado' , 'visivel' , 'created_at' , 'updated_at'];

    public function adicionarMensagens(array $dados ) : ?Mensagens {


        return $this->create([
            'created_at' => now() , 
            'meuperfil_id' => $dados['meuperfil_id'] ,
            'mensagem' => $dados['mensagem'] , 
            'livros_id' => $dados['livros_id'] ,
        ] );
    }

    public function deletarMensagens( int  $id ) : bool {

        $mensagem = $this->find($id)->update(['visivel' => false ]); 
        if($mensagem){
            return true;
        }else{
            return false; 
        }
    }

    public function editarMensagens(array $dados ) : ?Mensagens { 
        $mensagens = $this->find($dados['id'])->update(['mensagem' => $dados['mensagem']]);
        if($mensagens ){
            return $this->find($dados['id']);
        }else{
            return null ;
        }
    }

    public function editarMensagensVisualizado( array $dados ) : bool {

        $mensagens = $this->where('meuperfil_id' , '=' , $dados['meuperfil_id'])
            ->where('livros_id' , '=' , $dados['livros_id'])
            ->update(['visualizado' => true , 'updated_at' => now() ] ); 

        return $mensagens ; 
    }

}
