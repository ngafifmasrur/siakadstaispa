<?php

namespace Modules\Admission\Http\Requests\Form\Phone;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($uid = false)
    {
        $id = $uid ?: auth()->id();

        return [
            'number'     => 'required|numeric|unique:user_phones,number,'.$id.',user_id',
            'whatsapp'   => 'boolean'
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

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'number' => 'nomor HP'
        ];
    }
}
