<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
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
        return [
            "email" => ["required", "email", "exists:users,email"],
            "otp" => ["required", "min:6", "max:6"],
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "Email field is required",
            "email.email" => "Please enter a valid email address",
            "email.exists" => "There is no user with this email",
            "otp.required" => "OTP field is required",
            "otp.min" => "Invalid OTP",
            "otp.max" => "Invalid OTP",
        ];
    }
}
