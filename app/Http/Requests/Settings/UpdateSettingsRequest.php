<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'gym_name' => 'required|string|max:255',
            'gym_address' => 'required|string|max:500',
            'gym_phone' => 'required|string|max:20',
            'gym_email' => 'required|email|max:255',
            'currency' => 'required|string|size:3',
            'timezone' => 'required|string|max:255',
            'business_hours_start' => 'required|date_format:H:i',
            'business_hours_end' => 'required|date_format:H:i',
            'max_members_per_trainer' => 'nullable|integer|min:1',
            'auto_logout_time' => 'nullable|integer|min:5|max:480',
            'enable_email_notifications' => 'boolean',
            'enable_sms_notifications' => 'boolean',
        ];
    }
}
