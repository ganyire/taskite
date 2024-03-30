<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): void
    {
        $teamName = $this->input('teamName');
        $this->merge([
            'teamName' => str($teamName)->replace(' ', '-')->lower()->toString(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'            => "required|max:255",
            'email'           => "required|email|unique:users,email",
            'password'        => ["required", "confirmed", Password::min(6)->mixedCase()->numbers()],
            'teamName'        => "required|max:255|unique:teams,name",
            'teamDisplayName' => 'sometimes|max:255',
        ];
    }

}
