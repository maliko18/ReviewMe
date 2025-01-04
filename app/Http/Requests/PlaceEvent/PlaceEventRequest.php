<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlaceEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Update this as per your authorization logic.
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'place_id' => 'required|exists:places,id',
        ];
    }
}
