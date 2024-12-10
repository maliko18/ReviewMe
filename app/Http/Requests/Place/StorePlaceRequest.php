<?php

namespace App\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;

class StorePlaceRequest extends FormRequest
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
            // Validation for Place
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'slug' => 'required|string|unique:places,slug',

            // Validation for Addresses
            'addresses' => 'required|array',
            'addresses.*.address' => 'required|string|max:255',
            'addresses.*.state' => 'required|string|max:255',
            'addresses.*.zip' => 'required|string|max:20',
            'addresses.*.coordinates' => 'nullable|array',
            'addresses.*.meta' => 'nullable|array',
            'addresses.*.city_id' => 'nullable|exists:cities,id',
            'addresses.*.country_id' => 'required|exists:countries,id',

            // Validation for Images
            'images' => 'nullable|array',
            'images.*' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
