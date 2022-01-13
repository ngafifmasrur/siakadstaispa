<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelasKuliahRequest extends FormRequest
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
            // 'id_semester' => 'required|integer',
            // 'id_matkul' => 'required|integer',
            'nama_kelas_kuliah' => 'required|string',
            'bahasan' => 'nullable|string',
            // 'tanggal_mulai_efektif' => 'nullable|date',
            // 'tanggal_akhir_efektif' => 'nullable|date',
        ];
    }
}
