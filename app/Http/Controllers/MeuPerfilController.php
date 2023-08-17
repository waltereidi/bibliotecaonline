<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Livros;
use App\Models\MeuPerfil;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

class MeuPerfilController extends Controller
{
    protected $users_id;

    public function __construc()
    {
        $this->users_id = Auth::id();
    }
    public function setUsersId($id)
    {
        $this->users_id = $id;
    }

    public function index()
    {
        $livrosModel = new Livros;
        if ($this->users_id === null && Auth::id() === null) return view('auth.login');

        (Auth::id() === null) ? $this->setUsersId(Auth::id()) : null;
        $dataSourcePerfil = MeuPerfil::where('users_id', $this->users_id)->first();

        $dataSourceLivros = $livrosModel->meuPerfilLivrosDoUsuario($this->users_id);
        $dataSourceQuantidadeLivros = $livrosModel->meuPerfilLivrosDoUsuarioQuantidade($this->users_id);

        return view('meuperfil', [
            'dataSourceLivros' => $dataSourceLivros,
            'dataSourceUsers' => $dataSourcePerfil,
            'dataSourceQuantidadeLivros' => $dataSourceQuantidadeLivros
        ]);
    }
    public function getDadosMeuPerfil(): JsonResponse
    {
        return response()->json(MeuPerfil::where('users_id', '=', Auth::id())->first(), 200);
    }

    public function validarLivrosRequest(Request $livros)
    {
        $regras = [
            'users_id' => 'required',
            'titulo' => 'required|string|max:60',
            'descricao' => 'nullable|string|max:1024',
            'visibilidade' => 'required|integer',
            'isbn' => 'nullable|string|max:20',
            'editoras_nome' => 'required|string|max:60',
            'autores_nome' => 'required|string|max:60',
            'capalivro' => 'nullable|max:512|url',
            'genero' => 'nullable|max:30|string',
            'idioma' => 'nullable|max:30|string',
        ];


        $mensagens = [
            'required' => 'Este campo é obrigatório',
            'max' => 'Limite de caracteres excedido',
            'url' => 'URL inválida'
        ];
        $dados = [
            'users_id' => $this->users_id,
            'titulo' => $livros['titulo'],
            'descricao' => (empty($livros->descricao) ? null : $livros->descricao),
            'visibilidade' => $livros->visibilidade,
            'isbn' => (empty($livros->isbn) ? null : $livros->isbn),
            'editoras_nome' => $livros->editoras_nome,
            'autores_nome' => $livros->autores_nome,
            'capalivro' => (empty($livros->capalivro) ? null : $livros->capalivro),
            'genero' => (empty($livros->genero) ? null : $livros->genero),
            'idioma' => (empty($livros->idioma) ? null : $livros->idioma),
        ];
        if (isset($livros->id)) {
            $regras['id'] = 'required';
            $dados['id'] = $livros->id;
        }

        return ['validador' => Validator::make($dados, $regras, $mensagens), 'dados' => $dados];
    }
    public function validarMeuPerfilRequest(Request $meuPerfil)
    {

        $regras = [
            'profile_picture' => 'url|string|max:1024',
            'introducao' => 'string|max:1024',
            'users_id' => 'required|integer',
            'datanascimento' => 'nullable|date',
        ];
        $mensagens = [
            'url' => 'URL inválida',
            'required' => 'Este campo é obrigatório',
        ];
        $dados = [
            'users_id' => $this->users_id,
            'profile_picture' => (empty($meuPerfil->profile_picture) ? null : $meuPerfil->profile_picture),
            'introducao' => (empty($meuPerfil->introducao) ? null : $meuPerfil->introducao),
            'datanascimento' => (empty($meuPerfil->datanascimento) ? null : Carbon::parse($meuPerfil->datanascimento)->locale('pt_BR')->toDateString()),
        ];

        return ['validador' => Validator::make($dados, $regras, $mensagens), 'dados' => $dados];
    }

    public function adicionarLivros(Request $livros)
    {
        $livrosModel = new Livros;
        if ($this->users_id === null && Auth::id() === null) return response()->json(['erro' => 'Nao autenticado'], 401);

        $validaLivrosRequrest = $this->validarLivrosRequest($livros);
        $validar = $validaLivrosRequrest['validador'];
        $dados = $validaLivrosRequrest['dados'];

        if ($validar->fails()) {
            return response()->json($validar->errors(), 417);
        } else {

            $livro = $livrosModel->adicionarLivros($dados);
            return $livro;
        }
    }

    public function editarLivros(Request $livros)
    {
        $livrosModel = new Livros;
        if ($this->users_id === null && Auth::id() === null) return response()->json(['erro' => 'Nao autenticado'], 401);

        $validaLivrosRequrest = $this->validarLivrosRequest($livros);
        $validar = $validaLivrosRequrest['validador'];
        $dados = $validaLivrosRequrest['dados'];

        if ($validar->fails()) {
            return response()->json($validar->errors(), 417);
        } else {
            $livro = $livrosModel->editarLivros($dados);
            return $livro;
        }
    }

    public function removerLivros($id): Bool
    {
        $livrosModel = new Livros;
        $livro = $livrosModel->find($id);
        if ($livro) {
            return $livro->delete();
        } else {
            return false;
        }
    }
    public function getPaginacaoLivrosDoUsuario(Request $request)
    {
        $livros = new Livros;
        return $livros->meuPerfilLivrosDoUsuario($request->users_id, $request->paginacao);
    }
    public function editarMeuPerfil(Request $request)
    {

        $validator = $this->validarMeuPerfilRequest($request);
        $dados = $validator['dados'];
        $validador = $validator['validador'];

        if ($validador->fails()) {
            return response()->json($validador->errors(), 417);
        } else {
            $meuPerfil = new MeuPerfil();
            return $meuPerfil->editarMeuPerfil($dados);
        }
    }
}
