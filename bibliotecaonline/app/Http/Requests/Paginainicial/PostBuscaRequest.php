<?php

namespace App\Http\Requests\Paginainicial;

use Illuminate\Foundation\Http\FormRequest;

class PostBuscaRequest extends FormRequest
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
            'busca' => ['min:3' ,'required' , 'max:60' ,'string']
        ];

    }
    public function messages():array
    {
        return [
            'required' => 'Campo obrigatório não preenchido' ,
            'min' =>'Campo deve possuir ao menos 3 caracteres' ,
            'max' =>'Limite de caracteres excedido',
        ];
    }
}
