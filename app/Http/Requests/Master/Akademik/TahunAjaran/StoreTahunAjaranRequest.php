<?php

namespace App\Http\Requests\Master\Akademik\TahunAjaran;

use Illuminate\Foundation\Http\FormRequest;

class StoreTahunAjaranRequest extends FormRequest
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
            'tahun_ajaran' => ['required', 'string'],
            // 'tahun_mulai' => ['required', 'date'],
            // 'tahun_selesai' => ['required', 'date'],
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
            // 'tahun_mulai.date' => 'Tahun mulai harus berupa tanggal',
            // 'tahun_selesai.required' => 'Tahun selesai ajaran tidak boleh kosong',
            // 'tahun_selesai.date' => 'Tahun selesai harus berupa tanggal',
            
            'tanggal_mulai.required' => 'Tanggal mulai ajaran tidak boleh kosong',
            'tanggal_mulai.date' => 'Tanggal mulai harus berupa tanggal',
            'tanggal_selesai.required' => 'Tanggal selesai ajaran tidak boleh kosong',
            'tanggal_selesai.date' => 'Tanggal selesai harus berupa tanggal',
            'periode.required' => 'Periode tahun ajaran harus diisi',
            'aktif.required' => 'Status tahun ajaran harus diisi'
        ];
    }
}
