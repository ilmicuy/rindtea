<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlamatRequest extends FormRequest
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
            'fullname' => 'required|string',
            'address' => 'required|string',
            'province_id' => 'required|string',
            'regency_id' => 'required|string',
            'label' => 'required|string',
            'postcode' => 'required|string',
            'phone' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'distance_in_km' => 'required',
        ];
    }
}
