<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveCamioneroRequest extends FormRequest
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
        if($this->isMethod('PATCH')){
            return [
                'nombre' => ['bail', 'required', 'max:32'],
                'apellido' => ['bail', 'required', 'max:32'],
            ];
        }

        return [
            'CI' => ['bail', 'required', 'digits:8', 'integer', 'unique:camioneros,CI'],
            'nombre' => ['bail', 'required', 'max:32'],
            'apellido' => ['bail', 'required', 'max:32'],
        ];
    }
}
