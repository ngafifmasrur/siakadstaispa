<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class KelasKuliahRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_akhir' => 'required|after:jam_mulai',
            'link_zoom' => 'string',
        ];

        // if(Auth::user()->role->name != 'admin_prodi'){
        //     $rules['id_prodi'] = 'required';
        // }

        return $rules;
    }
}
