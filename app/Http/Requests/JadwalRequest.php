<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class JadwalRequest extends FormRequest
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
            'id_kelas' => 'required',
            'id_matkul_aktif' => 'required|integer',
            'id_ruang' => 'required|integer',
            'id_dosen' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_akhir' => 'required|date_format:H:i|after:jam_mulai',
        ];

        
        if(Auth::user()->role->name != 'admin_prodi'){
            $rules['id_prodi'] = 'required';
        }

        return $rules;
    }
}
