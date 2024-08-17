<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'departement' => 'required',
            'position' => 'required',
            'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?=.*\d).+$/',
            'password_confirmation' => 'required|same:password',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role wajib diisi',
            'departement.required' => 'Departement wajib diisi',
            'position.required' => 'Posisi wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.regex' => 'Password harus mengandung 1 huruf kecil, 1 huruf besar, 1 angka, dan 1 karakter spesial',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi',
            'password_confirmation.same' => 'Konfirmasi password tidak cocok',
        ];
    }
}
