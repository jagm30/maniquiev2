<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumnos extends FormRequest
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
            //
            'apaterno'  => 'required|max:255',
            'amaterno'  => 'required|max:255',


        ];
    }
    public function messages()
    {
        return [
            'apaterno' => 'Apellido paterno requerido',
            'amaterno'  => 'Apellido materno requerido',
        ];
    }
   /* public function attributes()
    {

    }*/
}
