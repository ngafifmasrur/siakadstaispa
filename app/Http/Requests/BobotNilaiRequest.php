<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BobotNilaiRequest extends FormRequest
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
            'nilai_huruf' => 'required|string',
            'nilai_indeks' => 'nullable|numeric',
            'bobot_minimum' => 'required|numeric',
            'bobot_maksimum' => 'required|numeric',
            'tanggal_mulai_efektif' => 'required|date',
            'tanggal_selesai_efektif' => 'required|date',
        ];
    }
}
