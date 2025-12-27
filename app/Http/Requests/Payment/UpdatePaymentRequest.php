<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'member_id' => 'required|exists:members,id',
            'plan_id' => 'required|exists:plans,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:payment_date',
            'payment_method' => 'required|in:cash,card,bank_transfer,digital_wallet,check',
            'status' => 'required|in:pending,completed,failed,refunded',
            'card_last_four' => 'nullable|string|max:4',
            'card_type' => 'nullable|string|max:50',
            'bank_name' => 'nullable|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
            'wallet_type' => 'nullable|string|max:50',
            'wallet_transaction_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'member_id.required' => 'Please select a member.',
            'plan_id.required' => 'Please select a plan.',
            'amount.required' => 'Payment amount is required.',
            'amount.min' => 'Payment amount must be greater than 0.',
            'payment_date.required' => 'Payment date is required.',
            'due_date.required' => 'Due date is required.',
            'due_date.after_or_equal' => 'Due date must be after or equal to payment date.',
            'payment_method.required' => 'Please select a payment method.',
            'status.required' => 'Please select a payment status.',
        ];
    }
}
