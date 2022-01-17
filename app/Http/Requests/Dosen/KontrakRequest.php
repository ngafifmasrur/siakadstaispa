<?php

namespace App\Http\Requests\Dosen;

use Illuminate\Foundation\Http\FormRequest;

class KontrakRequest extends FormRequest
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
        $mimes = 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:2048';

        return [
            'kontrak_belajar' => 'required',
            'path_kontrak_belajar' => 'nullable|'. $mimes,
            'path_rpp' => 'required|'. $mimes,
        ];
    }
}
