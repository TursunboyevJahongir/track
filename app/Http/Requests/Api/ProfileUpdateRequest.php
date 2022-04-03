<?php

namespace App\Http\Requests\Api;

use App\Rules\PhoneRule;
use App\Rules\UniqueRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'full_name' => 'filled|string',
            'email' => 'nullable|string',
            'phone' => [
                'filled',
                new PhoneRule(),
                new UniqueRule('users', 'phone', $this->route('user',auth()->user())->id),
            ],
            'password' => ['filled', 'string', 'confirmed', Password::min(8)->letters()->numbers()],
            'avatar' => 'image',
        ];
    }
}
