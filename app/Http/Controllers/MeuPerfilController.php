<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeuPerfil\DeleteLivrosRequest;
use App\Http\Requests\MeuPerfil\PostLivrosRequest;
use App\Http\Requests\MeuPerfil\PutLivrosRequest;
use App\Http\Requests\MeuPerfil\PutMeuPerfilRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Livros;
use App\Models\MeuPerfil;
use Illuminate\Http\JsonResponse;

class MeuPerfilController extends Controller
{
    protected $users_id;
    protected $livrosModel;
    protected $meuPerfil;
    public function __construct()
    {
        $this->users_id = Auth::id();
        $this->livrosModel = new Livros;
        $this->meuPerfil = new MeuPerfil;
    }
    public function setUsersId($id)
    {
        $this->users_id = $id;
    }

    public function index()
    {

        if ($this->users_id === null && Auth::id() === null) return view('auth.login');

        (Auth::id() === null) ? $this->setUsersId(Auth::id()) : null;
        $dataSourcePerfil = MeuPerfil::where('users_id', $this->users_id)->first();

        $dataSourceLivros = $this->livrosModel->meuPerfilLivrosDoUsuario($this->users_id);
        $dataSourceQuantidadeLivros = $this->livrosModel->meuPerfilLivrosDoUsuarioQuantidade($this->users_id);

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
            'capalivro' => ['nullable', 'max:512', 'url'],
            'genero' => 'nullable|max:30|string',
            'idioma' => 'nullable|max:30|string',
            'urldownload' => ['required', 'max:2048', 'url'],
        ];


        $mensagens = [
            'required' => 'Este campo é obrigatório',
            'max' => 'Limite de caracteres excedido',
            'url' => 'URL inválida'
        ];
        $dados = [
            'users_id' => $this->users_id,
            'titulo' => $livros->titulo,
            'descricao' => (empty($livros->descricao) ? null : $livros->descricao),
            'visibilidade' => $livros->visibilidade,
            'isbn' => (empty($livros->isbn) ? null : $livros->isbn),
            'editoras_nome' => $livros->editoras_nome,
            'autores_nome' => $livros->autores_nome,
            'capalivro' => (empty($livros->capalivro) ? null : $livros->capalivro),
            'genero' => (empty($livros->genero) ? null : $livros->genero),
            'idioma' => (empty($livros->idioma) ? null : $livros->idioma),
            'urldownload' => $livros->urldownload,
        ];
        if (isset($livros->id) && $livros->id != null) {
            $regras['id'] = 'required';
            $dados['id'] = $livros->id;
        }

        return ['validador' => Validator::make($dados, $regras, $mensagens), 'dados' => $dados];
    }
    public function validarMeuPerfilRequest(Request $meuPerfil)
    {

        $regras = [
            'profile_picture' => 'url|string|max:2048',
            'introducao' => 'string|max:2048',
            'users_id' => 'required|integer',
            'datanascimento' => 'nullable',
        ];
        $mensagens = [
            'url' => 'URL inválida',
            'required' => 'Este campo é obrigatório',
        ];
        $dados = [
            'users_id' => $this->users_id,
            'profile_picture' => (empty($meuPerfil->profile_picture) ? null : $meuPerfil->profile_picture),
            'introducao' => (empty($meuPerfil->introducao) ? null : $meuPerfil->introducao),
            'datanascimento' => (empty($meuPerfil->datanascimento) ? null : $meuPerfil->datanascimento ),
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

        if ($this->users_id === null && Auth::id() === null) return response()->json(['erro' => 'Nao autenticado'], 401);

        $validaLivrosRequrest = $this->validarLivrosRequest($livros);
        $validar = $validaLivrosRequrest['validador'];
        $dados = $validaLivrosRequrest['dados'];

        if ($validar->fails()) {
            return response()->json($validar->errors(), 417);
        } else {
            $livro = $this->livrosModel->editarLivros($dados);
            return $livro;
        }
    }

    public function removerLivros($id): Bool
    {

        $livro = $this->livrosModel->find($id);
        if ($livro) {
            return $livro->delete();
        } else {
            return false;
        }
    }
    public function getPaginacaoLivrosDoUsuario(Request $request)
    {

        $parametros = $request->all();
        return $this->livrosModel->meuPerfilLivrosDoUsuario(Auth::id(), empty($request->paginacao) ? 0 : $request->paginacao);
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

    public function deleteLivros(DeleteLivrosRequest $request): JsonResponse
    {
        $dados = $request->all();
        $retorno = $this->removerLivros($dados['id']);
        if (!$retorno) {
            return response()->json('Livro não encontrado', 204);
        } else {
            return response()->json('Livro deletado com sucesso', 200);
        }
    }
    public function postLivros(PostLivrosRequest $request): JsonResponse
    {
        $dados = $request->all();
        $retorno = $this->livrosModel->adicionarLivros($dados);
        if (!isset($retorno->id)) {
            return response()->json($retorno, 500);
        } else {
            return response()->json($retorno, 201);
        }
    }
    public function putLivros(PutLivrosRequest $request): JsonResponse
    {
        $dados = $request->all();
        $retorno = $this->livrosModel->editarLivros($dados);
        if (!isset($retorno->id)) {
            if ($retorno == false) {
                return response()->json('Livro não encontrado', 204);
            } else {
                return response()->json($retorno, 500);
            }
        } else {
            return response()->json($retorno, 200);
        }
    }
    public function putMeuPerfil(PutMeuPerfilRequest $request): JsonResponse
    {
        $dados = $request->all();
        $retorno = $this->meuPerfil->editarMeuPerfil($dados);
        if (!isset($retorno->id)) {
            if($retorno == null ){
                return response()->json('MeuPerfil não encontrado.', 204);
            }else{
                response()->json($retorno , 500);
            }
        }
        else
        {
            return response()->json($retorno, 200);
        }
    }
}
