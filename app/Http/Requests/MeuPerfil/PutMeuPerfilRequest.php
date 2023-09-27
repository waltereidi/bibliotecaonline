<?php

namespace App\Http\Requests\MeuPerfil;

use Illuminate\Foundation\Http\FormRequest;

class PutMeuPerfilRequest extends FormRequest
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
            'id' => ['required' , 'integer'],
            'introducao' => ['nullable' , 'max:2048' , 'string'] ,
            'profile_picture' => ['nullable' , 'string' , 'url'] ,
            'datanascimento' => ['nullable' ,'date_format:d/m/Y' ] ,
            'users_id' => ['required' , 'integer'] ,
        ];
    }
    public function messages():array
    {
        return[
            'required' => 'Campo obrigatório não preenchido',
          'max'=>'Limite de caracteres excedido',
          'url'=>'Url inválida',
          'date'=>'Data inválida'
        ];
    }
}
