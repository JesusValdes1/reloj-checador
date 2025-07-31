<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveEmpleadoRequest extends FormRequest
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

        $rules['matricula'] = [ 'required',
                                Rule::unique('empleados')->ignore($this->route('empleado')),
                                'digits:5' ];
        $rules['activo'] = '';
        $rules['nombre'] = 'required|max:40';
        // $rules['apellido_paterno'] = 'required|max:40';
        $rules['apellido_paterno'] = 'max:40';
        $rules['apellido_materno'] = 'max:40';
        $rules['correo'] = 'nullable|max:100|email';
        $rules['foto'] = 'nullable|max:100|mimes:jpeg';
        $rules['area'] = 'required|max:80';
        $rules['puesto'] = 'required|max:80';

        if ( is_null($this['apellido_materno']) ) $rules['apellido_paterno'] = 'required|' . $rules['apellido_paterno'];

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
            'matricula.required' => 'El campo Matricula es requerido',
            'matricula.unique' => 'El valor del campo Matricula ya existe',
            'matricula.digits' => 'El campo Matricula debe ser de :digits dígitos',
            'nombre.required' => 'El Nombre es requerido',
            'nombre.max' => 'El Nombre debe tener máximo :max caracteres',
            'apellido_paterno.required' => 'El Apellido Paterno es requerido',
            'apellido_paterno.max' => 'El Apellido Paterno debe tener máximo :max caracteres',
            'apellido_materno.max' => 'El Apellido Materno debe tener máximo :max caracteres',
            'correo.max' => 'El Correo debe tener máximo :max caracteres',
            'correo.email' => 'Debe ingresar un correo electrónico válido',
            'foto.mimes' => 'La foto debe ser un archivo de tipo JPEG',
            'foto.max' => 'La foto debe tener máximo :max caracteres',
            'area.required' => 'El Área es requerida',
            'area.max' => 'El Área debe tener máximo :max caracteres',
            'puesto.required' => 'El Puesto es requerido',
            'puesto.max' => 'El Puesto debe tener máximo :max caracteres'
        ];
    }
}
