<?php

namespace App\Http\Requests\Dosen;

use Illuminate\Foundation\Http\FormRequest;

class MateriPerkuliahanRequest extends FormRequest
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
            'id_prodi' => 'required',
            'id_matkul' => 'required',
            'judul' => 'required',
            'path_file' => $this->route('id') ? 'nullable|'. $mimes : 'required|'. $mimes,
            'link' => 'nullable|url'
        ];
    }
}
