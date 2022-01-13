<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class MahasiswaRequest extends FormRequest
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
            'id_agama' => 'required|integer',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'nik' => 'required|string',
            'nama_mahasiswa' => 'required|string',
            'tempat_lahir' => 'required|string',
            'nisn' => 'nullable|string',
            'nik' => 'required|string',
            'jalan' => 'nullable|string',
            'rt' => 'nullable|string',
            'rw' => 'nullable|string',
            'dusun' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'nama_ayah' => 'nullable|string',
            'tanggal_lahir_ayah' => 'nullable|date',
            'nik_ayah' => 'nullable|string',
            'id_jenjang_pendidikan_ayah' => 'nullable|integer',
            'id_pekerjaan_ayah' => 'nullable|integer',
            'id_penghasilan_ayah' => 'nullable|integer',
            'id_kebutuhan_khusus_ayah' => 'nullable|integer',
            'tanggal_lahir_ibu' => 'nullable|date',
            'nik_ibu' => 'nullable|string',
            'id_jenjang_pendidikan_ibu' => 'nullable|integer',
            'id_pekerjaan_ibu' => 'nullable|integer',
            'id_penghasilan_ibu' => 'nullable|integer',
            'id_kebutuhan_khusus_ibu' => 'required|integer',
            'nama_wali' => 'nullable|string',
            'tanggal_lahir_wali' => 'nullable|date',
            'nik_wali' => 'nullable|string',
            'id_jenjang_pendidikan_wali' => 'nullable|integer',
            'id_pekerjaan_wali' => 'nullable|integer',
            'id_penghasilan_wali' => 'nullable|integer',
            'id_kebutuhan_khusus_mahasiswa' => 'nullable|integer',
            'telepon' => 'required|string',
            'handphone' => 'nullable|string',
            'email' => 'nullable|email',
            'penerima_kps' => 'required|in:1,0',
            'no_kps' => 'nullable|string',
            'npwp' => 'nullable|string',
            'id_wilayah' => 'required|integer',
            'kewarganegaraan' => 'required|string',
            'id_jenis_tinggal' => 'nullable|integer',
            'id_alat_transportasi' => 'nullable|integer',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            if(Auth::user()->role->name == 'admin'){
                $rules['nim'] = 'required|string|unique:users,email,'.$this->mahasiswa->user->id;
            } elseif(Auth::user()->role->name == 'mahasiswa') {
                $rules['nim'] = 'required|string|unique:users,email,'.Auth::user()->id;
            }
        }

        if (in_array($this->method(), ['POST'])) {
            $rules['nim'] = 'required|string|unique:users,email';
        }



        return $rules;
    }
}
