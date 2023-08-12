<?php

namespace App\Http\Requests\Mensagens;

use Illuminate\Foundation\Http\FormRequest;

class PutMensagensVisualizadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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

    public function messages() : array 
    {
        return [
            'required' => 'Este campo é obrigatório' ,
        ];
    }
}
