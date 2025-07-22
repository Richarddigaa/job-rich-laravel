<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateJobVacancyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    // untuk mengubah text menjadi angka untuk gaji
    public function prepareForValidation()
    {
        $this->merge([
            'job_salary_first' => preg_replace('/[^0-9]/', '', $this->input('job_salary_first')),
            'job_salary_last' => preg_replace('/[^0-9]/', '', $this->input('job_salary_last')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'job_position' => ['required', 'string'],
            'job_city' => ['required', 'string'],
            'job_salary_first' => ['required', 'integer'],
            'job_salary_last' => ['required', 'integer'],
            'job_status' => ['required', 'string'],
            'job_deadline' => ['required', 'date'],
            'job_description' => ['required', 'string', 'max:65535'],
            'job_address' => ['required', 'string', 'max:65535'],
        ];
    }

    public function messages() // pesan error dari validasi
    {
        return [
            'job_position.required' => 'Posisi Pekerjaan tidak boleh kosong.',
            'job_city.required' => 'Kota Penempatan tidak boleh kosong.',
            'job_salary_first.required' => 'Kisaran Gaji Awal tidak boleh kosong.',
            'job_salary_last.required' => 'Kisaran Gaji Akhir tidak boleh kosong.',
            'job_status.required' => 'Status Lowongan pilih salah satu.',
            'job_deadline.required' => 'Batas Lowongan tidak boleh kosong.',
            'job_description.required' => 'Deskripsi Pekerjaan tidak boleh kosong.',
            'job_address.required' => 'Alamat Penempatan tidak boleh kosong.',
        ];
    }
}
