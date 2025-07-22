<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProfileApplicantRequest extends FormRequest
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
            'avatars_applicant' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'name_applicant' => ['required', 'string'],
            'email_applicant' => ['required', 'string', 'email'],
            'phone_applicant' => ['required', 'string'],
            'city_applicant' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'date_of_birth_applicant' => ['required', 'date'],
            'sumary_applicant' => ['required', 'string', 'max:65535'],
        ];
    }

    public function messages() // pesan error dari validasi
    {
        return [
            'name_applicant.required' => 'Nama tidak boleh kosong.',
            'email_applicant.required' => 'Email tidak boleh kosong.',
            'email_applicant.email' => 'Format email tidak valid.',
            'phone_applicant.required' => 'Nomor Telepon tidak boleh kosong.',
            'city_applicant.required' => 'Kota Domisili tidak boleh kosong.',
            'gender.required' => 'Jenis Kelamin tidak boleh kosong.',
            'date_of_birth_applicant.required' => 'Tanggal Lahir tidak boleh kosong.',
            'sumary_applicant.required' => 'Ringkasan Diri tidak boleh kosong.',
        ];
    }
}
