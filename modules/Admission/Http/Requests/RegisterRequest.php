<?php

namespace Modules\Admission\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        $rules = [
            'pob'           => 'required|string|max:191',
            'dob'           => 'required|string|date_format:d-m-Y',
            'sex'           => 'required|in:'.join(',', array_keys(config('web.references.sexes'))),
            'admission_id'  => [
                'required',
                Rule::exists('Modules\Admission\Models\Admission', 'id')->where(function($query) {
                    $query->where('published', 1);
                })
            ]
        ];

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'admission_id' => 'jalur pendaftaran',
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
