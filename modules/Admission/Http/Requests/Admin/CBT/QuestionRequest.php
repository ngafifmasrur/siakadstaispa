<?php

namespace Modules\Admission\Http\Requests\Admin\CBT;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'cbt_id'    => 'required|integer',
            'soal'      => 'required',
            'jawaban_a' => 'required|string',
            'jawaban_b' => 'required|string',
            'jawaban_c' => 'required|string',
            'jawaban_d' => 'required|string',
            'jawaban_e' => 'nullable|string',
            'jawaban_benar' => 'nullable|string',
            'skor' => 'required',

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }
}
