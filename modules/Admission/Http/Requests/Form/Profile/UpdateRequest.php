<?php

namespace Modules\Admission\Http\Requests\Form\Profile;

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
            'name'          => 'required|string|max:191',
            'prefix'        => 'nullable|string|max:50',
            'suffix'        => 'nullable|string|max:50',
            'pob'           => 'required|string|max:191',
            'dob'           => 'required|string|date_format:d-m-Y',
            'sex'           => 'required|in:'.join(',', array_keys(config('web.references.sexes'))),
            'blood'         => 'nullable|in:'.join(',', array_keys(config('web.references.bloods'))),
            'nik'           => 'required|digits_between:1,16|unique:user_profile,nik,'.$id.',user_id',
            'nokk'          => 'required|digits_between:1,16',
            'country'       => 'required|numeric|exists:ref_countries,id',
            'avatar'        => 'nullable|file|image|max:1024',
            'child_order'   => 'required|numeric|min:1|max:20',
            'siblings'      => 'required|numeric|gte:child_order|max:20',
            'biological'    => 'required|boolean',
            'illness'       => 'nullable|string|max:191',
            'nisn'          => 'required|digits_between:1,10',
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
            // 'dob.after_or_equal'  => 'Mohon maaf, usia Anda tidak boleh melampaui batas persyaratan pendaftaran. (Maks: '.config('admission.maximum-dob-year').')',
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
            'prefix' => 'gelar depan',
            'name' => 'nama lengkap',
            'suffix' => 'gelar belakang',
            'pob' => 'tempat lahir',
            'dob' => 'tanggal lahir',
            'sex' => 'jenis kelamin',
            'blood' => 'golongan darah',
            'nik' => 'NIK',
            'nokk' => 'nomor KK',
            'country' => 'kewarganegaraan',
            'avatar' => 'foto pendaftar',
            'child_order' => 'urutan anak',
            'siblings' => 'jumlah saudara',
            'biological' => 'status anak',
            'illness' => 'riwayat penyakit',
            'nisn' => 'NISN',
        ];
    }
}
