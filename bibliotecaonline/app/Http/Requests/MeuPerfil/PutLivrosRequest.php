<?php

namespace App\Http\Requests\MeuPerfil;

use Illuminate\Foundation\Http\FormRequest;

class PutLivrosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required','integer'],
            'users_id' => ['required'],
            'titulo' => ['required', 'string', 'max:60'],
            'descricao' => ['nullable', 'string', 'max:1024'],
            'visibilidade' => ['required', 'integer'],
            'isbn' => ['nullable', 'string', 'max:20'],
            'editoras_nome' => ['required', 'string', 'max:60'],
            'autores_nome' => ['required', 'string', 'max:60'],
            'capalivro' => ['nullable', 'max:512', 'url'],
            'genero' => ['nullable', 'max:30', 'string'],
            'idioma' => ['nullable', 'max:30', 'string'],
            'urldownload' => ['required', 'max:2048', 'string', 'url'],
        ];
    }
    public function messages(): array
    {
        return [
            'required' => 'Campo obrigatório não preenchido',
            'max' => 'Limite de caracteres excedido',
            'url' => 'url inválida',
        ];
    }
}
