<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_id' => 'required|exists:members,id',
            'date' => 'required|date',
            'check_in' => 'required|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'workout_duration' => 'nullable|integer|min:1',
            'workout_type' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'member_id.required' => 'Please select a member.',
            'date.required' => 'Attendance date is required.',
            'check_in.required' => 'Check-in time is required.',
            'check_out.after' => 'Check-out time must be after check-in time.',
        ];
    }
}
