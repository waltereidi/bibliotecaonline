<?php

namespace App\Http\Requests\Mensagens;

use Illuminate\Foundation\Http\FormRequest;

class GetMensagensLivrosRequest extends FormRequest
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
            'livros_id' => ['required'  ] ,
        ];

    }
    public function messages(): array 
    {
        return [
            'livros_id.required' => 'este campo é obrigatório' , 
        ];
    }
}
