<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenugasanDosenRequest extends FormRequest
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
            'id_dosen' => 'required',
            'id_tahun_ajaran' => 'required',
            'id_prodi' => 'required',
            'nomor_surat_tugas' => 'required',
            'tanggal_surat_tugas' => 'required|date',
            'mulai_surat_tugas' => 'required|date',
        ];
    }
}
