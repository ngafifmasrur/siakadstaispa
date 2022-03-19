<?php

namespace Modules\Admission\Http\Requests\Form\Parent;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules($uid = false)
    {
        $id = $uid ?: auth()->id();

        return [
            // 'nik'               => 'required|digits_between:1,16',
            'name'              => 'required|string|max:191',
            // 'pob'               => 'required|string|max:191',
            // 'dob'               => 'required|date_format:d-m-Y',
            // 'ktp'               => 'nullable|file|image|max:1024',
            'is_dead'           => 'required|boolean',
            'biological'        => 'required|boolean',
            'grade'             => 'required|exists:ref_grades,id',
            'employment'        => 'required|exists:ref_employments,id',
            'salary'            => 'required|exists:ref_salaries,id',
            // 'address'           => 'required|string|max:191',
            // 'rt'                => 'nullable|string|max:10',
            // 'rw'                => 'nullable|string|max:10',
            // 'village'           => 'nullable|string|max:191',
            // 'district'          => 'required|exists:ref_province_regency_districts,id',
            // 'postal'            => 'required|string|max:5',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'nik'               => 'NIK',
            'name'              => 'nama lengkap',
            'pob'               => 'tempat lahir',
            'dob'               => 'tanggal lahir',
            'ktp'               => 'tanda pengenal',
            'is_dead'           => 'keadaan',
            'grade'             => 'pendidikan terakhir',
            'biological'        => 'status',
            'employment'        => 'pekerjaan',
            'salary'            => 'penghasilan',
            'address'           => 'alamat',
            'rt'                => 'RT',
            'rw'                => 'RW',
            'village'           => 'kelurahan',
            'district'          => 'kecamatan',
            'postal'            => 'kode pos',
        ];
    }
}
