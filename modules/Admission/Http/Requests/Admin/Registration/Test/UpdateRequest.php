<?php

namespace Modules\Admission\Http\Requests\Admin\Registration\Test;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'test.*.value'       => 'required|numeric|between:0,100',
            'test.*.description' => 'nullable|string|max:191'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'test.*.value.between'  => 'Nilai valid adalah antara 0 sampai 100',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
