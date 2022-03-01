<?php

namespace Modules\Admission\Http\Requests\Admin\Registration\Payment;

use App\Rules\OldPassword;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'item.*'        => 'exists:instance_period_regs,id',
            'payer'         => 'required|string|max:191',
            'payed_at'      => 'required|date_format:"d-m-Y H:i:s"',
            'cash'          => 'nullable|boolean',
            'description'   => 'nullable|string|max:191',
            'password'      => ['required', new OldPassword]
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
