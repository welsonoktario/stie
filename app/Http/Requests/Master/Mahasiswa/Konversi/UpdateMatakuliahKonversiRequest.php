<?php

namespace App\Http\Requests\Master\Mahasiswa\Konversi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatakuliahKonversiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'kode_matakuliah' => 'required|max:100',
            'nama_matakuliah' => 'required|max:100',
            'sks' => 'required|numeric',
            'nilai' => 'required|numeric',
            'matakuliah_baru_id' => 'required|numeric'
        ];
    }


    /**
     * Return message for the following validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'kode_matakuliah.required' => 'Kode Matakuliah Asal tidak boleh kosong!',
            'nama_matakuliah.required' => 'Nama Matakuliah Asal tidak boleh kosong!',
            'sks.required' => 'SKS Asal tidak boleh kosong!',
            'nilai.required' => 'Nilai tidak boleh kosong!',
            'matakuliah_baru_id.required' => 'Matakuliah yang diakui tidak boleh kosong!',
        ];
    }
}
