<?php

namespace App\Http\Requests\Trainer;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'specialization' => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'certifications' => 'nullable|array',
            'bio' => 'nullable|string',
            'hourly_rate' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'working_hours' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The trainer name is required.',
            'email.required' => 'The email address is required.',
            'email.unique' => 'This email is already registered.',
            'specialization.required' => 'Please specify the trainer specialization.',
            'experience_years.required' => 'Years of experience is required.',
            'hourly_rate.required' => 'Hourly rate is required.',
        ];
    }
}
