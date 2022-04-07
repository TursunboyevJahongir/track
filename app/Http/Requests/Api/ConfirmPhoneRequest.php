<?php

namespace App\Http\Requests\Api;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmPhoneRequest extends FormRequest
{
    public function attributes()
    {
        return [
            'phone' => __('attributes.phone'),
            'code' => __('attributes.code'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return ['phone' => ['required', new PhoneRule(), 'exists:sms_confirms,phone'],
            'code' => 'required|integer|min:1000|max:9999',
            'role' => 'exists:roles,name'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
