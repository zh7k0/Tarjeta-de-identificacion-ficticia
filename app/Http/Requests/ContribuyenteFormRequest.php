<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContribuyenteFormRequest extends FormRequest
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
            'razon_social' => 'required|max:100',
            'domicilio' => 'required|max:100',

        ];
    }

    public function messages()
    {
        return [
            'required' => 'Por favor ingrese :attribute.',
            'razon_social.max' => 'Razón social es muy larga, máximo 100 caracteres.',
            'razon_social.unique' => 'Razón social ya existe.',
            'domicilio.max' => 'Domicilio es muy largo, máximo 100 caracteres.'
        ];
    }

     /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'razon_social' => 'razón social',
        ];
    }
}
