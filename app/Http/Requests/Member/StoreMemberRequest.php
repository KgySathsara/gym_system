<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
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
            'trainer_id' => 'nullable|exists:trainers,id',
            'plan_id' => 'required|exists:plans,id',
            'join_date' => 'required|date',
            'expiry_date' => 'required|date|after:join_date',
            'status' => 'required|in:active,inactive,suspended',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'medical_conditions' => 'nullable|string',
            'fitness_goals' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The member name is required.',
            'email.required' => 'The email address is required.',
            'email.unique' => 'This email is already registered.',
            'plan_id.required' => 'Please select a membership plan.',
            'join_date.required' => 'Join date is required.',
            'expiry_date.required' => 'Expiry date is required.',
            'expiry_date.after' => 'Expiry date must be after join date.',
        ];
    }
}
