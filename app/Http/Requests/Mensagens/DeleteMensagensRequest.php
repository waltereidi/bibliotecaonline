<?php

namespace App\Http\Requests\Mensagens;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMensagensRequest extends FormRequest
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
            'id' => ['required' , 'number' ]
        ];
    }

    public function messages(): array 
    {
        return [
            'id.required' => 'O ID da mensagem deve estar preenchido.'
        ];
    }
}
