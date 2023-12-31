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
    protected $table = 'livros';
    protected $fillable = [
        'titulo', 'descricao', 'isbn', 'visibilidade', 'users_id',
        'editoras_id', 'autores_id', 'created_at', 'updated_at', 'genero', 'idioma','urldownload', 'capalivro'
    ];

    public function meuPerfilLivrosDoUsuario($users_id, $paginacao = 0)
    {
        $livrosDoUsuario = DB::table('livros')
            ->join('editoras', 'editoras.id', '=', 'livros.editoras_id')
            ->join('autores', 'autores.id', '=', 'livros.autores_id')
            ->select(
                'livros.id as id',
                'livros.users_id as users_id',
                'livros.titulo as titulo',
                'livros.isbn as isbn',
                'livros.descricao as descricao',
                'livros.visibilidade as visibilidade',
                'editoras.id as editoras_id',
                'editoras.nome as editoras_nome',
                'autores.id as autores_id',
                'autores.nome as autores_nome',
                'livros.idioma as idioma',
                'livros.genero as genero',
                'livros.capalivro as capalivro',
                'livros.urldownload as urldownload',
                DB::raw($paginacao . ' as paginacao')
            )
            ->where('livros.users_id', $users_id)->orderBy('livros.updated_at', 'desc')
            ->skip($paginacao)->limit(6)->get();

        return ($livrosDoUsuario->count() === 0) ?  null : $livrosDoUsuario;
    }
    public function meuPerfilLivrosDoUsuarioQuantidade($users_id)
    {
        return Livros::where('users_id', '=', $users_id)->count();
    }

    public function adicionarLivros($livros)
    {
        DB::beginTransaction();
        try {

            $autores = new Autores();
            $autor = $autores->adicionarAutorInexistente($livros['autores_nome']);

            $editoras = new Editoras();
            $editora = $editoras->adicionarEditoraInexistente($livros['editoras_nome']);
            $createLivros = [
                'titulo' => $livros['titulo'],
                'descricao' => (empty($livros['descricao']) ? null : $livros['descricao']),
                'isbn' => (empty($livros['isbn']) ? null : $livros['isbn']),
                'visibilidade' => $livros['visibilidade'],
                'users_id' => $livros['users_id'],
                'editoras_id' => $editora->id,
                'autores_id' => $autor->id,
                'capalivro' => (empty($livros['capalivro']) ? null : $livros['capalivro']),
                'genero' => (empty($livros['genero']) ? null : $livros['genero']),
                'idioma' => (empty($livros['idioma']) ? null : $livros['idioma']),
                'urldownload' => $livros['urldownload'],
                'created_at' => now()
            ];
            $livro = Livros::create($createLivros);
            DB::commit();
            return $livro;
        } catch (Exception $e) {
            DB::rollBack();
            return $e ;
        }
    }

    public function editarLivros($livros)
    {
        try {
            DB::beginTransaction();
            $livroUpdate = Livros::find($livros['id']);

            $autores = new Autores();
            $autor = $autores->adicionarAutorInexistente($livros['autores_nome']);

            $editoras = new Editoras();
            $editora = $editoras->adicionarEditoraInexistente($livros['editoras_nome']);

            if($livroUpdate){
            $livro = $livroUpdate->update([
                'titulo' => $livros['titulo'],
                'descricao' => empty($livros['descricao']) ? null : $livros['descricao'],
                'isbn' => empty($livros['isbn']) ? null : $livros['isbn'],
                'visibilidade' => $livros['visibilidade'],
                'editoras_id' => $editora->id,
                'autores_id' => $autor->id,
                'capalivro' => empty($livros['capalivro']) ? null : $livros['capalivro'],
                'genero' => empty($livros['genero']) ? null : $livros['genero'],
                'idioma' => empty($livros['idioma']) ? null : $livros['idioma'],
                'urldownload'=>$livros['urldownload'],
                'updated_at' => now(),
            ]);
            }
            if ($livro) {
                DB::commit();
                return Livros::find($livros['id']);
            } else {
                DB::rollBack();
                return $livro;
            }
        } catch (Exception $e) {
            DB::rollBack();
            return null;
        }
    }
    public function postBuscaIndice(int $quantidade ,int $iniciopagina , array $busca  ) : ?array
    {

        $query =DB::table('livros')
        ->join('editoras' , 'editoras.id' ,'=' ,'livros.editoras_id')
        ->join('autores' , 'autores.id' ,'=' ,'livros.autores_id')
        ->select(
            'livros.id as id',
            'livros.users_id as users_id',
            'livros.titulo as titulo',
            'livros.isbn as isbn',
            'livros.descricao as descricao',
            'livros.visibilidade as visibilidade',
            'editoras.id as editoras_id',
            'editoras.nome as editoras_nome',
            'autores.id as autores_id',
            'autores.nome as autores_nome',
            'livros.idioma as idioma',
            'livros.genero as genero',
            'livros.capalivro as capalivro',
            'livros.urldownload as urldownload'
        )
        ->limit($quantidade);
        if(!(count($busca) == 1 && strtolower($busca[0]['tipo'])  == 'todos'))
        {
        foreach( $busca as $filtro){
            switch( strtolower($filtro['tipo']) ){
                case 'testcase' :
                    $query->orWhere( 'livros.genero', '=' ,'TestCase-1');
                    break;
                case 'genero' :
                    $query->orWhere('livros.genero' , 'ilike' ,'%'.$filtro['indice'].'%');
                case 'editoras':
                    $query->orWhere('editoras.nome' , 'ilike' , '%'.$filtro['indice'].'%');
                    break;
            }
        }}

    $retorno = ['quantidadeTotal'=>$query->count() , 'livros'=>$query->offset($iniciopagina)->get()];
    return $retorno ;
    }
    public function getIndices() : ?object
    {
        $editoras = DB::table('livros')
            ->join('editoras' , 'editoras.id' ,'=' ,'livros.editoras_id')
            ->select('editoras.nome as indice')
            ->selectRaw("'editoras' as tipo")
            ->selectRaw('count(*) as quantidade')
            ->groupBy('editoras.nome')
            ->orderBy('quantidade')
            ->orderBy('editoras.nome')
            ->limit(10);
        $generos = DB::table('livros')
            ->select('genero as indice')
            ->selectRaw("'genero' as tipo")
            ->selectRaw('count(*) as quantidade')
            ->whereNotNull('genero')
            ->groupBy('genero')
            ->orderBy('quantidade')
            ->orderBy('genero')
            ->limit(10);
        $todos = DB::table('livros')
            ->selectRaw("'Todos' as indice")
            ->selectRaw("'Todos' as tipo")
            ->selectRaw('count(*) as quantidade')
            ->union($editoras)
            ->union($generos)
            ->get();

            return $todos;
    }
    public function postBusca(string $busca) : ?array
    {
        $query =DB::table('livros')
        ->join('editoras' , 'editoras.id' ,'=' , 'livros.editoras_id' )
        ->join('autores' , 'autores.id' , '=' ,'livros.autores_id')
        ->select(
            'livros.id as id',
            'livros.users_id as users_id',
            'livros.titulo as titulo',
            'livros.isbn as isbn',
            'livros.descricao as descricao',
            'livros.visibilidade as visibilidade',
            'editoras.id as editoras_id',
            'editoras.nome as editoras_nome',
            'autores.id as autores_id',
            'autores.nome as autores_nome',
            'livros.idioma as idioma',
            'livros.genero as genero',
            'livros.capalivro as capalivro',
            'livros.urldownload as urldownload'
        )
        ->whereRaw(" ( editoras.nome <-> ? ) <= 0.8 " , $busca )
        ->orWhereRaw(" ( autores.nome <-> ? ) <= 0.8 " , $busca )
        ->orWhereRaw(" ( livros.titulo <-> ? ) <= 0.8 " , $busca )
        ->orWhereRaw(" ( livros.genero <-> ? ) <= 0.8 " , $busca )
        ->orWhereRaw(" ( livros.isbn <-> ? ) <= 0.2 " , $busca )
        ->limit(30);
        $quantidadeTotal = $query->count();
        $retorno = ['quantidadeTotal'=>$quantidadeTotal , 'livros'=>$query->get()];
        return $retorno;

    }
    public function getLivro(int $id) : ?object
    {
        return DB::table('livros')
        ->join('autores' , 'autores.id' , '=' ,'livros.autores_id')
        ->join('editoras' ,'editoras.id' , '=' , 'livros.editoras_id')
        ->join('users','users.id' , '=' , 'users_id' )
        ->select(
            'livros.id as id',
            'livros.users_id as users_id',
            'livros.titulo as titulo',
            'livros.isbn as isbn',
            'livros.descricao as descricao',
            'livros.visibilidade as visibilidade',
            'editoras.id as editoras_id',
            'editoras.nome as editoras_nome',
            'autores.id as autores_id',
            'autores.nome as autores_nome',
            'livros.idioma as idioma',
            'livros.genero as genero',
            'livros.capalivro as capalivro',
            'livros.urldownload as urldownload',
            'livros.users_id as users_id',
            'users.name as users_nome'
        )
        ->where('livros.id' , '=' ,$id)->first();

    }
    public function postLivrosMeuPerfil($dados) : ?object
    {
        $offset = $dados['pagina']<=1? 0 :($dados['quantidade']*$dados['pagina']);
        $retorno = DB::table('livros')
        ->join('autores' , 'autores.id' , '=' ,'livros.autores_id')
        ->join('editoras' ,'editoras.id' , '=' , 'livros.editoras_id')
        ->join('meuperfil' , 'meuperfil.users_id' ,'=' ,'livros.users_id')
        ->select(
            'livros.id as id',
            'livros.users_id as users_id',
            'livros.titulo as titulo',
            'livros.isbn as isbn',
            'livros.descricao as descricao',
            'livros.visibilidade as visibilidade',
            'editoras.id as editoras_id',
            'editoras.nome as editoras_nome',
            'autores.id as autores_id',
            'autores.nome as autores_nome',
            'livros.idioma as idioma',
            'livros.genero as genero',
            'livros.capalivro as capalivro',
            'livros.urldownload as urldownload',
            'livros.users_id as users_id',
        )
        ->where('meuperfil.id' , '=' , $dados['meuperfil_id'])
        ->orderBy('livros.updated_at','desc')
        ->offset($offset)
        ->limit($dados['quantidade'])
        ->get();
        if(!(count($retorno) > 0) )
        {
            return null ;
        }
        else
        {
            return $retorno ;
        }
    }
    public function getPerfilUsuarioLivros(int $users_id , int $offset) : ?object
    {
        $retorno= DB::table('livros')
        ->select(
            'livros.id as id' ,
            'livros.titulo as titulo' ,
            'autores.nome as autores_nome' ,
            'livros.capalivro as capalivro'
        )
        ->join('autores' , 'autores.id' , '=' , 'livros.autores_id')
        ->where('livros.users_id' ,'=' , $users_id)
        ->offset($offset)
        ->limit(6)
        ->get();
        if(count($retorno) == 0 )
        {
            return null;
        }else{
            return $retorno;
        }

    }
}
