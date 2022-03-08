<?php

namespace Modules\Admission\Http\Requests\Form\Organizations;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'name'              => 'required|string|max:191',
            'type'              => 'required|exists:ref_organization_types,id',
            'year'              => 'required|date_format:Y|before_or_equal:'.date('Y'),
            'duration'          => 'required|digits__between:0,3',
            'position'          => 'required|exists:ref_organization_positions,id',
            'file'              => 'nullable|file|image|max:1024',
            'description'       => 'nullable|string|max:191',
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
            'name'              => 'nama organisasi',
            'type'              => 'jenis organisasi',
            'year'              => 'tahun',
            'duration'          => 'lama menjabat',
            'position'          => 'jabatan',
            'file'              => 'bukti keorganisasian',
            'description'       => 'deskripsi',
        ];
    }
}
