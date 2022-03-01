<?php

namespace Modules\Admission\Http\Requests\Form\Achievements;

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
            'territory'         => 'required|exists:ref_territories,id',
            'type'              => 'required|exists:ref_achievement_types,id',
            'num'               => 'required|exists:ref_achievement_nums,id',
            'year'              => 'required|date_format:Y|before_or_equal:'.date('Y'),
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
            'name'              => 'nama prestasi',
            'territory'         => 'tingkat',
            'type'              => 'jenis prestasi',
            'num'               => 'peringkat',
            'year'              => 'tahun',
            'file'              => 'bukti keikutsertaan',
            'description'       => 'deskripsi',
        ];
    }
}
