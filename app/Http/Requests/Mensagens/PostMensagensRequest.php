<?php

namespace App\Http\Requests\Mensagens;

use Illuminate\Foundation\Http\FormRequest;

class PostMensagensRequest extends FormRequest
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
            'mensagem' => ['required','string' , 'max:1024'] , 
            'livros_id' => ['required'] , 
            'meuperfil_id' => ['required'] ,
        ];
    }

    public function messages(): array 
    {
        return [
            'required' => 'Campo obrigatório não preenchido'
        ];

    }
    
}
