<?php

namespace App\Http\Requests\Dosen;

use Illuminate\Foundation\Http\FormRequest;

class PublikasiRequest extends FormRequest
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
            'sifat_publikasi' => 'required',
            'tahun' => 'required|integer',
            'judul' => 'required',
            'tempat_publikasi' => 'required',
            'link' => 'nullable|url',
        ];
    }
}
