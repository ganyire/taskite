<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * ------------
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * ------------
     */
    public function rules(): array
    {
        return [
            'email'                 => "required|email|exists:users,email",
            'emailVerificationCode' => "required|exists:users,email_verification_code",
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     * ------------
     */
    public function messages(): array
    {
        return [
            'email.required'                 => 'Email is required',
            'email.email'                    => 'Email must be a valid email address',
            'email.exists'                   => 'Email address given not found in the records',
            'emailVerificationCode.required' => 'Email verification code is required',
            'emailVerificationCode.exists'   => 'Invalid email verification code',
        ];
    }
}
