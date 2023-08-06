<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Autores;
use App\Models\Editoras;
use Exception;

class Livros extends Model
{
    use HasFactory;
    protected $table = 'livros' ; 
    protected $fillable = ['titulo','descricao','isbn','visibilidade','users_id','editoras_id','autores_id'];

    public function meuPerfilLivrosDoUsuario( $users_id ) {
        $livrosDoUsuario = DB::table('livros')
        ->join('editoras' , 'editoras.id' , '=' , 'livros.editoras_id')
        ->join('autores' , 'autores.id' , '=' , 'livros.autores_id' )
        ->select('livros.users_id as users_id' , 'livros.titulo as titulo' , 'livros.isbn as isbn' ,
                'livros.descricao as descricao' , 'livros.visibilidade as visibilidade' , 
                'editoras.id as editoras_id' , 'editoras.nome as editoras_nome' , 
                'autores.id as autores_id' , 'autores.nome as autores_nome' ,
                DB::raw('0  as paginacao'))
        ->where('livros.users_id' , $users_id )
        ->orderBy('livros.created_at' , 'desc')->skip(0)->limit(30)->get();

        return $livrosDoUsuario->count() > 0 ? $livrosDoUsuario : null ; 
    }

    public function adicionarLivros( $livros ) : ?Livros {
        DB::beginTransaction();

        try{
            $autores = new Autores ; 
            $autor = $autores->adicionarAutorInexistente($livros['autores_nome']);
            
            $editoras = new Editoras ; 
            $editora = $editoras->adicionarEditoraInexistente($livros['editoras_nome']);
            $createLivros = [
                'titulo' => $livros['titulo'] , 
                'descricao' => $livros['descricao'] , 
                'isbn' => $livros['isbn'],
                'visibilidade' => $livros['visibilidade'] , 
                'users_id' => $livros['users_id'] , 
                'editoras_id' => $editora->id , 
                'autores_id' => $autor->id
            ];

            $livro = Livros::create($createLivros);
            DB::commit();
            return $livro ; 
        }catch(Exception $e){
            DB::rollBack();
            return response()->json($e , 501 ) ; 
        }
    }

    public function editarLivros( $livros )  {
        DB::beginTransaction();
        try{
            
            $autores = new Autores ; 
            $autor = $autores->adicionarAutorInexistente($livros['autores_nome']);
            
            $editoras = new Editoras ; 
            $editora = $editoras->adicionarEditoraInexistente($livros['editoras_nome']);
            
            $livro = Livros::find($livros['id'])->update([
                'titulo' => $livros['titulo'],
                'descricao' => $livros['descricao'],
                'isbn' => $livros['isbn'],
                'visibilidade' => $livros['visibilidade'],
                'editoras_id' => $editora->id  ,
                'autores_id' => $autor->id ,
            ]);
            if($livro){
                return Livros::find($livros['id']);
            }else{
                return $livro;
            }
             
            DB::commit();
            return $livro;
            
        }catch(Exception $e ){
            DB::rollBack();
            return response()->json($e , 501 );
        }
    }
}
