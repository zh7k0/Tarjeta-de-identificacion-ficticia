<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ServicioFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
                'tipo_servicio' => ['bail', 'required', 'max:45', 'not_regex:/[+$%]/'], 
                'razon_social' => 'bail|required|max:100', 
                'rut' => 'bail|required|max:12', 
                'giro' => 'bail|required|max:100', 
                'domicilio' => 'bail|required|max:100', 
                'comuna' => 'bail|required|max:35', 
                'logo' => $this->method() == 'PUT' ? '' : 'bail|required|image|mimes:png|max:1024|file',
        ];
    }

    /**
     * Get the customized message for every rule configured
     */
    public function messages()
    {
        return [
            'required' => 'Por favor ingrese :attribute.',
            'unique' => 'Nombre de servicio ya existe.',
            'max' => ':attribute debe contener a lo mas :max carácteres.',
            'image' => 'El archivo debe ser una imagen.',
            'mimes' => 'El logo debe ser de tipo PNG.',
            'logo.max' => 'El logo debe pesar menos de :max KB.',
        ];
    }

    public function attributes()
    {
        return [
            'tipo_servicio' => 'nombre de servicio',
            'razon_social' => 'razón social', 
        ];
    }
}
