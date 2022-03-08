<?php

namespace Modules\Admission\Http\Requests\Admin\Database\Manage\Registrant;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        $rules = [
            'name'          => 'required|string|max:191',
            'pob'           => 'required|string|max:191',
            'dob'           => 'required|string|date_format:d-m-Y',
            'sex'           => 'required|in:'.join(',', array_keys(config('web.references.sexes'))),
            'admission_id'  => [
                'required',
                Rule::exists('Modules\Admission\Models\Admission', 'id')->where(function($query) {
                    $query->where('open', 1);
                })
            ],
            'username'  => 'required|min:4|max:191|regex:/^[a-z\d.]{4,20}$/|unique:users,username',
        ];

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.unique' => 'Isian :attribute sudah digunakan oleh orang lain, silahkan gunakan :attribute lainnya.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'admission_id' => 'jalur pendaftaran',
            'name' => 'nama lengkap',
            'pob' => 'tempat lahir',
            'dob' => 'tanggal lahir',
            'sex' => 'jenis kelamin',
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
