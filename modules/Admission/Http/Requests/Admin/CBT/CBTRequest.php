<?php

namespace Modules\Admission\Http\Requests\Admin\CBT;

use Illuminate\Foundation\Http\FormRequest;

class CBTRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'admission_id'       => 'integer',
            'mapel'              => 'required|string|max:191',
            'kode_mapel'         => 'required|string',
            'description'        => 'nullable',
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
            'mapel'             => 'nama mata pelajaran',
            'kode_mapel'        => 'kode mata pelajaran',
            'description'       => 'deskripsi',
        ];
    }
}
