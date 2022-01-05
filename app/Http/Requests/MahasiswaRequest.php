<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'id_prodi' => 'required|integer',
            'id_agama' => 'required|integer',
            'id_periode' => 'required|integer',
            'id_status_mahasiswa' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'nim' => 'required|unique:users,email',
            'nama_mahasiswa' => 'required|string',
            'password' => 'sometimes|min:8',
        ];
    }
}
