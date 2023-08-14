<?php

namespace App\Http\Requests\ListaDeAmigos;

use Illuminate\Foundation\Http\FormRequest;

class PostListaDeAmigosRequest extends FormRequest
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
            'livros_id' => ['required' , 'number'] ,
            'meuperfil_id' => ['required' , 'number'] , 
        ];
    }
    public function mensagens() : array {

        return [
            'required' => 'Este campo é obrigatório' ,
        ];

    }
    
}
