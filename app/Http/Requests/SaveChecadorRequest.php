<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveChecadorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = array();

        $rules['ip'] = [
            'required',
            Rule::unique('checadores')->ignore($this->route('checadore')),
            'ipv4'
        ];
        $rules['activo'] = '';
        // $rules['nombre'] = 'required|max:80';
        $rules['nombre'] = [
            'required',
            Rule::unique('checadores')->ignore($this->route('checadore')),
            'max:80'
        ];
        $rules['descripcion'] = 'max:255';
        $rules['ubicacion'] = 'required|max:100';

        return $rules;
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'ip.required' => 'El campo IP es requerido',
            'ip.unique' => 'El valor del campo IP ya existe',
            'ip.ipv4' => 'El campo IP no tiene una dirección IP válida',
            'nombre.required' => 'El Nombre es requerido',
            'nombre.unique' => 'El valor del campo Nombre ya existe',
            'nombre.max' => 'El Nombre debe tener máximo :max caracteres',
            'descripcion.max' => 'La Descripción debe tener máximo :max caracteres',
            'ubicacion.required' => 'La Ubicación es requerida',
            'ubicacion.max' => 'La Ubicación debe tener máximo :max caracteres'
        ];
    }
}
