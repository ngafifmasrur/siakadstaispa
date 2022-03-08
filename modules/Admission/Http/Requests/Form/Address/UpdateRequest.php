<?php

namespace Modules\Admission\Http\Requests\Form\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'address'       => 'required|string|max:191',
            'rt'            => 'nullable|numeric',
            'rw'            => 'nullable|numeric',
            'village'       => 'required|string|max:191',
            'district'      => 'required|exists:ref_province_regency_districts,id',
            'postal'        => 'required|numeric',
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
            'address'       => 'alamat',
            'rt'            => 'RT',
            'rw'            => 'RW',
            'village'       => 'kelurahan',
            'district'   => 'kecamatan',
            'postal'        => 'kode pos',
        ];
    }
}
