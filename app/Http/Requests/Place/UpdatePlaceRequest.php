<?php

namespace App\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlaceRequest extends FormRequest
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
        return [
            // Validation for Place
            'id' => 'nullable|exists:places,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',

            // Validation for Addresses
            'addresses' => 'nullable|array',
            'addresses.*.id' => 'nullable|exists:addresses,id',
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
            'remove_image_ids' => 'nullable|array',
            'remove_image_ids.*' => 'exists:images,id',
        ];
    }
}
