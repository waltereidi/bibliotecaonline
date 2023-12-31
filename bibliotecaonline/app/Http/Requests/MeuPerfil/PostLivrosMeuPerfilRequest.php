<?php

namespace App\Http\Requests\MeuPerfil;

use Illuminate\Foundation\Http\FormRequest;

class PostLivrosMeuPerfilRequest extends FormRequest
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
            'quantidade' => ['integer','required'] ,
            'pagina' => ['integer' , 'required'] ,
            'meuperfil_id' => ['integer' , 'required'],
            //
        ];
    }
    public function messages() : array
    {
        return [
            'required' => 'Campo obrigatório não preenchido'
        ];
    }
}
