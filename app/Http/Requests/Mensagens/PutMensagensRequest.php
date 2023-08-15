<?php

namespace App\Http\Requests\Mensagens;

use Illuminate\Foundation\Http\FormRequest;

class PutMensagensRequest extends FormRequest
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
            'id' => ['required' ] , 
            'mensagem' => 'required' ,'string' , 'max:1024' , 
        ];
    }
    public function messages(): array 
    {
        return [ 
            'required' => 'Campo obrigatório não preenchido' , 
            'max:1024' => 'limite de caracteres excedido' ,  
        ];    
    }
}
