<?php

namespace Modules\Admission\Http\Requests\Admin\CBT;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'registrant_id'     => 'required|integer',
            'question_id'       => 'required|integer',
            'jawaban_benar'     => 'required',
            'jawaban_peserta'   => 'required',
            'skor'              => 'required',
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
