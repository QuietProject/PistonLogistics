<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SaveVehiculoRequest extends FormRequest
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
                'peso_max' => ['bail', 'required', 'integer', 'gt:0'],
                'vol_max' => ['bail', 'required', 'numeric', 'gt:0']
            ];
        }

        return [
             'matricula' => ['bail', 'regex:^[A-Za-z]{3}[0-9]{4}$^',  'unique:vehiculos,matricula'],
             'peso_max' => ['bail', 'required', 'integer', 'gt:0'],
             'vol_max' => ['bail', 'required', 'numeric', 'gt:0'],
             'tipo' => [ 'required', Rule::in(['camion', 'camioneta'])]
        ];
    }
}
