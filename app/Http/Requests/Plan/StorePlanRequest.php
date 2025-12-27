<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class StorePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'sessions_per_week' => 'required|integer|min:1|max:7',
            'has_trainer' => 'boolean',
            'is_active' => 'boolean',
            'features' => 'nullable|string', // Keep as string for textarea input
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Plan name is required.',
            'price.required' => 'Plan price is required.',
            'duration_days.required' => 'Plan duration is required.',
            'sessions_per_week.required' => 'Sessions per week is required.',
        ];
    }
}
