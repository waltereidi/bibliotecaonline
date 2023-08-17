<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class PostGetDadosUsers extends FormRequest
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
            'email' => ['required', 'string', 'max:255', 'email'],
            'password' => ['required', 'string', 'max:255']
        ];
    }
    public function messages(): array
    {
        return [
            'required' => 'Campo obrigatório não preenchido',
            'string' => 'Este campo deve ser uma string',
            'max' => 'Limite de caracteres excedido',
            'email' => 'Email inválido',
        ];
    }
}
