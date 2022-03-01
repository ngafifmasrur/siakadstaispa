<?php

namespace Modules\Admission\Http\Requests\Admin\Registration\Major;

use Modules\Admission\Models\AdmissionRegistrant;
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
            'major1'        => 'required|different:major2|in:'.join(',', array_keys(AdmissionRegistrant::$major)),
            'major2'        => 'required|different:major1|in:'.join(',', array_keys(AdmissionRegistrant::$major)),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'major1' => 'pilihan 1',
            'major2' => 'pilihan 2'
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
