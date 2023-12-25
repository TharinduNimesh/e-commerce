<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $password_regex = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";
        return [
            'email' => ['required', "email", "exists:users,email"],
            'password' => ['required', "regex:$password_regex", 'confirmed'],
            'otp' => ['required', 'min:6', 'max:6']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email address is required',
            'email.email' => 'Email address is invalid',
            'email.exists' => 'Email Address doesn\'t match with our records.',
            'password.required' => 'New password is required',
            'password.regex' => 'Password doesn\'t meet the requirements.',
            'password.confirmed' => 'Passwords don\'t match with confirm password.',
            'otp.required' => 'OTP is required',
            'otp.min' => 'Invalid OTP',
            'otp.max' => 'Invalid OTP'
        ];
    }
}
