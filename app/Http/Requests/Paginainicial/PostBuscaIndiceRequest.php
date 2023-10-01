<?php

namespace App\Http\Requests\Paginainicial;

use Illuminate\Foundation\Http\FormRequest;

class PostBuscaIndiceRequest extends FormRequest
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
            'busca'=>['array' , 'required'],
            'busca.*.indice' => ['required' , 'string' , 'max:60'] ,
            'busca.*.tipo' => ['required' , 'string' ,'max:30'] ,
            'quantidade'=>['integer','required'],
            'iniciopagina'=>['integer','required'],
        ];
    }
    public function messages(): array
    {
        return [
            'required' => 'Campo obrigatório não preenchido',
            'array' => 'Array de formato inválido',
            'max' => 'Limite de caracteres excedido'
        ];

    }
}
