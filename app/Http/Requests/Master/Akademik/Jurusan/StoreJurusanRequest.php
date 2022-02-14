<?php

namespace App\Http\Requests\Master\Akademik\Jurusan;

use Illuminate\Foundation\Http\FormRequest;

class StoreJurusanRequest extends FormRequest
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
            'kode_jurusan' => ['required', 'string'],
            'nama' => ['required', 'string']
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
            'kode_jurusan.required' => 'Kode jurusan tidak boleh kosong',
            'nama.required' => 'Nama jurusan tidak boleh kosong',
        ];
    }
}
