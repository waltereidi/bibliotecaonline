<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function getMensagensCaixa( int $meuPerfilId ) : ?object {
        return $this->join('meuperfil' , 'meuperfil.id', '=' , DB::raw( $meuPerfilId ))
            ->join('users' , 'users.id' , '=' , 'meuperfil.users_id' ) 
            ->join('livros' , function( JoinClause $join ){
              $join->on('livros.id' , '=' ,  'mensagens.livros_id' )->orON('livros.users_id' , '=' , 'users.id' ) ;
            } )
            ->join('autores' , 'autores.id' , '=' , 'livros.autores_id' ) 
            ->join('editoras' , 'editoras.id' , '=' , 'livros.editoras_id') 
            ->select( DB::raw( 'distinct( livros.id ) as livros_id' ) ,
               DB::raw( 'max(mensagens.created_at ) over( partition by livros.id ) as created_at ' ) , 
               DB::raw( '( max( case visualizado when true then 0 when false then 1 end ) over( partition by livros.id ) ) = 0 as visualizado' ) , 
              'mensagens.id as id ' ,
              'meuperfil.id as meuperfil_id' ,
              'livros.titulo as livro_titulo' , 
              'autores.nome as autores_nome' , 'autores.id as autores_id' , 
              'editoras.nome as editoras_nome' , 'editoras.id as editoras_id' 
              )->where('mensagens.visivel' , '=' , 'true')->get();
    }

    public function getMensagensLivros( array $dados ) : ?object { 
        return $this->leftJoin('livros' , 'livros.id' , '=' , DB::raw( $dados['livros_id'] ) ) 
            ->select('mensagens.mensagem as mensagem' , 'mensagens.livros_id as livros_id' , 
                'mensagens.visualizado as visualizado' , 'mensagens.created_at as created_at' , 
                'mensagens.meuperfil_id as meuperfil_id' )
            ->whereRaw( 'mensagens.visivel AND mensagens.livros_id = ? AND ( (mensagens.meuperfil_id = ? OR livros.users_id = ? ) )  ' , 
            [ intval($dados['livros_id']) , intval($dados['meuperfil_id']) , intval($dados['users_id']) ] 
            )
            ->get();
    } 

}
