<?php

namespace App\Http\Requests\Master\Akademik\Matakuliah;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatakuliahRequest extends FormRequest
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
            'kurikulum_id' => ['required', 'numeric'],
            'kode_matakuliah' => ['required', 'string', 'max:10'],
            'nama_matakuliah' => ['required', 'string', 'max:45'],
            'sks' => ['required', 'digits_between:1,10'],
            'tipe' => ['required', 'in:wajib,pilihan,pilihan wajib', 'string'],
            'semester' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'kurikulum_id.required' => 'Kurikulum matakuliah tidak boleh kosong',
            'kode_matakuliah.required' => 'Kode matakuliah tidak boleh kosong',
            'kode_matakuliah.max' => 'Panjang kode matakuliah tidak boleh lebih dari 10 huruf',
            'nama_matakuliah.required' => 'Nama matakuliah tidak boleh kosong',
            'nama_matakuliah.max' => 'Panjang nama matakuliah tidak boleh lebih dari 45',
            'sks.required' => 'SKS matakuliah tidak boleh kosong',
            'sks.digits_between' => 'SKS matakuliah minimal 1 dan maksimal 10',
            'tipe.required' => 'Tipe matakuliah tidak boleh kosong',
            'tipe.in' => 'Tipe matakuliah harus berupa Wajib, Pilihan, atau Wajib Pilihan'
        ];
    }
}
