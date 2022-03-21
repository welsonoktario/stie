<?php

namespace App\Http\Requests\Transaksi\JadwalMahasiswa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateJadwalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     // $levelPengguna = Auth::user()->staff->level_pengguna;

    //     // return $levelPengguna == 'Administrator' || $levelPengguna == 'Staff';
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'jadwal_id' => ['required', 'numeric'],
            'mahasiswa_npm' => ['required', 'numeric']
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
            'jadwal_id.required' => 'Jadwal tidak boleh kosong',
            'mahasiswa_npm.required' => 'Pilih mahasiswa',
        ];
    }
}
