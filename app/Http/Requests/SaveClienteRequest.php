<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->isMethod('PATCH')) {
            return [
                'nombre' => ['bail', 'required', 'max:32', 'unique:CLIENTES,nombre']
            ];    
        }
        return [
            'RUT' => ['bail', 'required', 'int', 'digits:12', 'unique:CLIENTES,RUT'],
            'nombre' => ['bail', 'required', 'max:32', 'unique:CLIENTES,nombre']
        ];
    }
}
