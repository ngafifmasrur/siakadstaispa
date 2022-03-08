<?php

namespace Modules\Admission\Http\Requests\Form\Email;

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
            'email'     => 'required|email|max:191|unique:user_emails,address,'.$id.',user_id',
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
            'email' => 'alamat e-mail'
        ];
    }
}
