<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')->id;
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|ignore:' . $userId,
            'password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->symbols()->numbers()->letters(), // Minimum length of 8 characters
                'confirmed', // Must match password_confirmation field
                'sometimes'
            ],
        ];
    }
}
