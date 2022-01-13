<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SemesterMHSRequest extends FormRequest
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
            'id_tahun_ajaran' => 'required',
            'id_mahasiswa' => 'required',
            'id_semester' => 'required',
            'id_prodi' => 'required',
            'status' => 'required',
        ];

        return $rules;
    }
}
