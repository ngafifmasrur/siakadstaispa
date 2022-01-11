<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DosenRequest extends FormRequest
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
            'nama_dosen' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'id_agama' => 'required|integer',
            'id_status_aktif' => 'required|integer',
            'nidn' => 'required|string',
            'nama_ibu' => 'required|string',
            'nik' => 'required|string',
            'nip' => 'nullable|string',
            'npwp' => 'nullable|string',
            'id_jenis_sdm' => 'required|nullable',
            'no_sk_cpns' => 'nullable|string',
            'tanggal_sk_cpns' => 'nullable|string',
            'no_sk_pengangkatan' => 'nullable|string',
            'mulai_sk_pengangkatan' => 'nullable|string',
            'id_lembaga_pengangkatan' => 'nullable|integer',
            'id_pangkat_golongan' => 'nullable|integer',
            'id_pangkat_golongan' => 'nullable|integer',
            'id_sumber_gaji' => 'nullable|integer',
            'jalan' => 'nullable|string',
            'dusun' => 'nullable|string',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'ds_kel' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'id_wilayah' => 'required|integer',
            'telepon' => 'required|string',
            'handphone' => 'nullable|string',
            'email' => 'nullable|email',
            'status_pernikahan' => 'nullable|string',
            'nip_suami_istri' => 'nullable|string',
            'id_pekerjaan_suami_istri' => 'nullable|integer',
            'mampu_handle_kebutuhan_khusus' => 'required',
            'mampu_handle_braille' => 'required',
            'mampu_handle_bahasa_isyarat' => 'required',
        ];
    }
}