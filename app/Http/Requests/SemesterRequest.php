<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SemesterRequest extends FormRequest
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
            'id_tahun_ajaran' => 'required',
            'semester' => 'required|numeric',
            'nama_semester' => 'required|string',
            'a_periode_aktif' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',

        ];
    }
}
