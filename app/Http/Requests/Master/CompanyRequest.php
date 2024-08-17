<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email'],
            'address' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'radius_km' => ['required'],
            'time_in' => ['required'],
            'time_out' => ['required'],
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
            'name.required' => 'Nama perusahaan wajib diisi',
            'email.required' => 'Email perusahaan wajib diisi',
            'email.email' => 'Email perusahaan tidak valid',
            'address.required' => 'Alamat perusahaan wajib diisi',
            'latitude.required' => 'Latitude perusahaan wajib diisi',
            'longitude.required' => 'Longitude perusahaan wajib diisi',
            'radius_km.required' => 'Radius KM perusahaan wajib diisi',
            'time_in.required' => 'Waktu masuk perusahaan wajib diisi',
            'time_out.required' => 'Waktu keluar perusahaan wajib diisi',
        ];
    }
}
