<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'dni' => 'required|string|exists:users,dni',
            'password' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
          'dni.required' => 'El campo DNI es obligatorio.',
          'dni.exists' => 'El campo DNI no existe.',
        ];
    }
}
