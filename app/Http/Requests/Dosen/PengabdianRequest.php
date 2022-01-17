<?php

namespace App\Http\Requests\Dosen;

use Illuminate\Foundation\Http\FormRequest;

class PengabdianRequest extends FormRequest
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
            'sumber_dana' => 'required',
            'nominal' => 'required|integer',
            'tahun' => 'required',
            'judul_pengabdian' => 'required'
        ];
    }
}
