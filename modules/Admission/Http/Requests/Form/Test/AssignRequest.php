<?php

namespace Modules\Admission\Http\Requests\Form\Test;

use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Models\AdmissionTestDate;
use Illuminate\Foundation\Http\FormRequest;

class AssignRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        $count = AdmissionRegistrant::whereDate('test_at', date('Y-m-d', strtotime($this->test_at)))->count();

        $repo = new AdmissionRegistrantRepository(new AdmissionRegistrant);
        $registrant = $repo->getCurrentUser();

        return [
            'test_at'           => [
                'required',
                'date:d-m-Y',
                function ($attribute, $value, $fail) use ($count, $registrant) {
                    if(auth()->user()->can('registration', Admission::class)) {
                        if(date('d-m-Y', strtotime($registrant->test_at)) != $value) {
                            if ($count >= config('admission.maximum-test-per-day')) {
                                $fail('Tanggal tes yang Anda pilih sudah penuh.');
                            }
                            if(AdmissionTestDate::whereDate('date', date('Y-m-d',strtotime($value)))->count() == 0) {
                                $fail('Tanggal tes tidak tersedia.');
                            }
                        }
                    }
                },
            ],
            'session'           => 'required|exists:admission_sessions,id',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes()
    {
        return [
            'test_at' => 'tanggal tes',
            'session' => 'sesi tes'
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
