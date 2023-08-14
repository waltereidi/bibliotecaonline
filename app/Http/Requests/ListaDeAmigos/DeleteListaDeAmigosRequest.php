<?php

namespace App\Http\Requests\ListaDeAmigos;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DeleteListaDeAmigosRequest extends FormRequest
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
            'meuperfil_id' => ['required' , 'number'] , 
            'meuperfilamigo_id' => ['required' , 'number'] , 
            'id' => ['required' , 'number'] , 
        ];
    }
    public function messages() : array
    {
        return [
            'meuperfil_id.required' => 'Este campo é obrigatório' , 
            'meuperfilamigo_id.required' => 'Este campo é obrigatório' , 
        ];
    }

}
