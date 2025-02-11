<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistroRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'grado' => 'required|string',
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'dni' => 'required|string|unique:users,dni',
            'password' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
        ];
    }

    public function messages(): array
    {
        return [
            'grado.required' => 'El campo grado es obligatorio',
            'nombre.required' => 'El campo nombre es obligatorio',
            'apellido.required' => 'El campo apellido es obligatorio',
            'dni.required' => 'El campo dni es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'El campo email debe ser un email',
            'email.unique' => 'El email se encuentra en uso',
            'password.required' => 'El campo password es obligatorio',
            'dni.unique' => 'El dni ya se encuentra registrado',
        ];
    }
}
