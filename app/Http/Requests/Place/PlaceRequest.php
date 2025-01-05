<?php

namespace App\Http\Requests\Place;

use Illuminate\Foundation\Http\FormRequest;

class PlaceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'address' => ['required', 'array'],
            'address.address' => ['required', 'string'],
            'address.state' => ['required', 'string'],
            'address.zip' => ['required', 'string'],
            'address.city_id' => ['required', 'exists:cities,id'],
            'address.country_id' => ['required', 'exists:countries,id'],
            'address.coordinates' => ['nullable', 'array'],
            'images.*' => ['image'],
            'deleted_images' => ['nullable', 'array'],
            'deleted_images.*' => ['exists:images,id']
        ];
    }
}
