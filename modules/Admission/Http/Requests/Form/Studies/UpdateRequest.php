<?php

namespace Modules\Admission\Http\Requests\Form\Studies;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'grade'          => 'required|exists:ref_grades,id',
            'name'              => 'required|string|max:255',
            'npsn'              => 'nullable|digits_between:0,50',
            'nss'               => 'nullable|digits_between:0,50',
            'from'              => 'nullable|date_format:Y|before_or_equal:'.date('Y'),
            'to'                => 'nullable|date_format:Y|after:from',
            'district'       => 'required|exists:ref_province_regency_districts,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'grade' => 'jenjang',
            'name' => 'nama sekolah/madrasah',
            'from' => 'tahun masuk',
            'to' => 'tahun selesai/keluar',
            'district' => 'kecamatan'
        ];
    }
}
