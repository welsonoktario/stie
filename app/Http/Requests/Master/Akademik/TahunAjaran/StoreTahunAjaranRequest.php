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
            'tahun_mulai' => ['required', 'numeric'],
            'tahun_selesai' => ['required', 'numeric'],
            'periode' => ['required', 'numeric'],
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
            'tahun_mulai.required' => 'Tahun mulai ajaran tidak boleh kosong',
            'tahun_mulai.numeric' => 'Tahun mulai harus berupa angka tahun',
            'tahun_selesai.required' => 'Tahun selesai ajaran tidak boleh kosong',
            'tahun_selesai.numeric' => 'Tahun selesai harus berupa angka tahun',
            'periode.required' => 'Periode tahun ajaran harus diisi',
        ];
    }
}
