<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SendEmailVerificationCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            'email' => "required|exists:users,email|email",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * ------------
     */
    public function messages(): array
    {
        return [
            'email.exists' => 'The email you entered does not exist.',
            'email.email'  => 'The email you entered is not valid.',
        ];
    }
}
