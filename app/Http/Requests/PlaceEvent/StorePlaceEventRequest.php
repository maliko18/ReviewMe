<?php

namespace App\Http\Requests\PlaceEvent;

use Illuminate\Foundation\Http\FormRequest;

class StorePlaceEventRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'place_id' => 'required|exists:places,id',
            'images' => 'array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif',
        ];
    }
}
