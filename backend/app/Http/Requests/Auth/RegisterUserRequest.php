<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    protected $mobile_regex = "/^(?:7|0|(?:\+94))[0-9]{9,10}$/";
    protected $password_regex = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";
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
            "first_name" => ["required", "min:2", "max:30"],
            "last_name" => ["required", "min:2", "max:30"],
            "mobile" => ["required", "regex:$this->mobile_regex", "unique:users"],
            "email" => ["required", "email", "unique:users"],
            "gender" => ["required", Rule::in(["Male", "Female"])],
            "password" => ["required", "regex:$this->password_regex"],
        ];
    }

    public function messages()
    {
        return [
            "mobile.regex" => "Valid LK mobile number is required.",
            "mobile.unique" => "This mobile number is already in use.",
            "email.unique" => "This email address is already in use.",
            "gender" => "Please select your gender.",
            "password" => "Password should have minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character:",
        ];
    }
}
