<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateComicRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'images' => ['required', 'array'],
            'price' => ['required', 'numeric'],
            'has_discount' => ['required', 'boolean'],
            'discount' => ['required_if:has_discount,true'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'string'],
            'publisher' => ['required', 'exists:publishers,_id'],
            'published_date' => ['required', 'date'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'images.required' => 'Images are required',
            'categories.required' => 'Categories are required',
        ];
    }
}
