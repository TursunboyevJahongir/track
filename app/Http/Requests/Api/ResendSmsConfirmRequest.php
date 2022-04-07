<?php

namespace App\Http\Requests\Api;


use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class ResendSmsConfirmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
                'phone' => ['required', new PhoneRule(), 'exists:sms_confirms,phone']
        ];
    }
}
