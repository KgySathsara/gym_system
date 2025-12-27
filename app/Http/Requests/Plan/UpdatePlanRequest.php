<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Make fields optional for partial updates
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'duration_days' => 'sometimes|required|integer|min:1',
            'sessions_per_week' => 'sometimes|required|integer|min:1|max:7',
            'has_trainer' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'features' => 'nullable|string',
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
