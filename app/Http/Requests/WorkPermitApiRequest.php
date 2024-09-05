<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkPermitApiRequest extends FormRequest
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
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
            'file' => 'nullable|file|mimes:pdf,jpg,png|max:1024',
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
            'start_date.required' => 'Tanggal mulai izin harus diisi',
            'end_date.required' => 'Tanggal selesai izin harus diisi',
            'reason.required' => 'Alasan harus diisi',
            'file.file' => 'File harus berupa file',
            'file.mimes' => 'File harus berupa pdf, jpg, atau png',
            'file.max' => 'File maksimal 1MB',
        ];
    }
}
