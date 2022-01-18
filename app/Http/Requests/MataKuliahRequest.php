<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class MataKuliahRequest extends FormRequest
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
        $rules = [
            'kode_mata_kuliah' => 'required|string',
            'nama_mata_kuliah' => 'required|string',
            'id_jenis_mata_kuliah' => 'required',
            'id_kelompok_mata_kuliah' => 'required',
            'sks_mata_kuliah' => 'required|numeric',
            'sks_tatap_muka' => 'required|numeric',
            'sks_praktek' => 'required|numeric',
            'sks_praktek_lapangan' => 'required|numeric',
            'sks_simulasi' => 'required|numeric',
            'metode_kuliah' => 'required|string',
            'tanggal_mulai_efektif' => 'required|date',
            'tanggal_selesai_efektif' => 'required|date',
        ];

        if(Auth::user()->role->name != 'admin_prodi'){
            $rules['id_prodi'] = 'required';
        }

        return $rules;

    }
}
