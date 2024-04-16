<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|string',
            'photos' => 'image',
            'quantity' => 'required|integer',
            'quality' => 'required|string',
            'thumb_description' => 'required|string',
            'short_description' => 'required|string',
            'long_description' => 'required|string',
            'price' => 'required|integer',
            'weight' => 'required|string',
            'check' => 'required|string',
            'country_of_origin' => 'required|string',
        ];
    }
}
