<?php

namespace App\Http\Requests\Master\Akademik\TahunAjaran;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTahunAjaranRequest extends FormRequest
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

    public function rules()
    {
        return [
            'tahun_ajaran' => ['required', 'string'],
            // 'tahun_mulai' => ['required', 'numeric'],
            // 'tahun_selesai' => ['required', 'numeric'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date'],
            'periode' => ['required', 'numeric'],
            'aktif' => ['required', 'boolean']
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
            'tahun_ajaran.required' => 'Tahun ajaran tidak boleh kosong',
            // 'tahun_mulai.required' => 'Tahun mulai ajaran tidak boleh kosong',
            // 'tahun_mulai.numeric' => 'Tahun mulai harus berupa angka tahun',
            // 'tahun_selesai.required' => 'Tahun selesai ajaran tidak boleh kosong',
            // 'tahun_selesai.numeric' => 'Tahun selesai harus berupa angka tahun',
            'tanggal_mulai.required' => 'Tahun mulai ajaran tidak boleh kosong',
            'tanggal_mulai.numeric' => 'Tahun mulai harus berupa tanggal',
            'tanggal_selesai.required' => 'Tahun selesai ajaran tidak boleh kosong',
            'tanggal_selesai.numeric' => 'Tahun selesai harus berupa tanggal',
            'periode.required' => 'Periode tahun ajaran harus diisi',
            'aktif.required' => 'Status tahun ajaran harus diisi'
        ];
    }
}
