<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SaveAlmacenRequest extends FormRequest
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
                'nombre' => ['required', 'max:32'],
                'direccion' => ['bail', 'required', 'max:128'],
            ];
        }

        return [
            'nombre' => ['required', 'max:32'],
            'direccion' => ['bail', 'required', 'max:128'],
            'tipo' => ['required', Rule::in(['propio', 'cliente'])],
            'RUT' => ['bail', 'required_if:tipo,cliente', 'int', 'digits:12', 'exists:clientes,RUT']
        ];
    }
}
