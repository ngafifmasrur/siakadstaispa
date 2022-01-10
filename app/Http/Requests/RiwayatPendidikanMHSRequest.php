<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RiwayatPendidikanMHSRequest extends FormRequest
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
            'id_prodi' => 'required',
            'id_jenis_daftar' => 'required',
            'id_jalur_daftar' => 'nullable',
            'id_periode_masuk' => 'required',
        ];
    }
}
