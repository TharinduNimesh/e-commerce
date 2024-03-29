<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddPaymentMethodRequest extends FormRequest
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
            'payment_type' => ['required', 'string', Rule::in(['Visa', 'Mastercard', 'Amex'])],
            'card_number' => ['required', 'string', 'size:16'],
            'expiry_date' => ['required', 'string', 'size:5'],
            'cvv' => ['required', 'string', 'size:3'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_type.required' => 'Payment type is required',
            'card_number.required' => 'Card number is required',
            'card_number.size' => 'Card number must be 16 digits',
            'expiry_date.required' => 'Expiry date is required',
            'expiry_date.size' => 'Expiry date must be in the format MM/YY',
            'cvv.required' => 'CVV is required',
            'cvv.size' => 'CVV must be 3 digits',
        ];
    }
}
