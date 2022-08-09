<?php

namespace App\Http\Requests\Transaksi\Jadwal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreJadwalRequest extends FormRequest
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
            'tahun_ajaran_id' => ['required', 'numeric'],
            'matakuliah_id' => ['required', 'numeric'],
            'ruangan_id' => ['required', 'numeric'],
            'hari' => ['required', 'string'],
            'jam' => ['required', 'string'],
            'local' => ['required', 'string', 'min:1']
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
            'tahun_ajaran_id.required' => 'Masukkan tahun ajaran',
            'matakuliah_id.required' => 'Matakuliah tidak boleh kosong',
            'ruangan_id.required' => 'Ruangan tidak boleh kosong',
            'hari.required' => 'Hari tidak boleh kosong',
            'jam' => 'Jam tidak boleh kosong',
            'local' => 'Local tidak boleh kosong'
        ];
    }
}
