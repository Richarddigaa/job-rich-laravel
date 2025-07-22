<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProfileCompanyRequest extends FormRequest
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
            'avatars_company' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'name_company' => ['required', 'string'],
            'email_company' => ['required', 'string', 'email'],
            'phone_company' => ['required', 'string'],
            'city_company' => ['required', 'string'],
            'address_company' => ['required', 'string', 'max:65535'],
            'type_of_company' => ['required', 'string'],
            'description_company' => ['required', 'string', 'max:65535'],
        ];
    }

    public function messages() // pesan error dari validasi
    {
        return [
            'name_company.required' => 'Nama Perusahaan tidak boleh kosong.',
            'email_company.required' => 'Email Perusahaan tidak boleh kosong.',
            'email_company.email' => 'Format email perusahaan tidak valid.',
            'phone_company.required' => 'Nomor Telepon Perusahaan tidak boleh kosong.',
            'city_company.required' => 'Kota Perusahaan tidak boleh kosong.',
            'address_company.required' => 'Alamat Perusahaan tidak boleh kosong.',
            'type_of_company.required' => 'Tipe Perusahaan tidak boleh kosong.',
            'description_company.required' => 'Deskripsi Perusahaan tidak boleh kosong.',
        ];
    }
}
