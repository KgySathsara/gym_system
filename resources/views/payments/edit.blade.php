@extends('layouts.app')

@section('title', 'Edit Payment')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-warning">
            <h3 class="card-title mb-0">
                <i class="fas fa-edit me-2"></i>Edit Payment
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('payments.update', $payment->id) }}" method="POST" id="paymentForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="member_id">Member *</label>
                            <select name="member_id" id="member_id" class="form-control @error('member_id') is-invalid @enderror" required>
                                <option value="">Select Member</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('member_id', $payment->member_id) == $member->id ? 'selected' : '' }}
                                        data-plan="{{ $member->plan_id }}">
                                        {{ $member->user->name }} ({{ $member->member_id ?? $member->id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('member_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="plan_id">Plan *</label>
                            <select name="plan_id" id="plan_id" class="form-control @error('plan_id') is-invalid @enderror" required>
                                <option value="">Select Plan</option>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}"
                                        {{ old('plan_id', $payment->plan_id) == $plan->id ? 'selected' : '' }}
                                        data-price="{{ $plan->price }}"
                                        data-duration="{{ $plan->duration_days }}">
                                        {{ $plan->name }} - ${{ number_format($plan->price, 2) }} ({{ $plan->duration_days }} days)
                                    </option>
                                @endforeach
                            </select>
                            @error('plan_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="amount">Amount ($) *</label>
                            <input type="number" name="amount" id="amount"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount', $payment->amount) }}"
                                    step="0.01" min="0" required
                                    placeholder="0.00">
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="payment_date">Payment Date *</label>
                            <input type="date" name="payment_date" id="payment_date"
                                    class="form-control @error('payment_date') is-invalid @enderror"
                                    value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}"
                                    required>
                            @error('payment_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="due_date">Due Date *</label>
                            <input type="date" name="due_date" id="due_date"
                                    class="form-control @error('due_date') is-invalid @enderror"
                                    value="{{ old('due_date', $payment->due_date->format('Y-m-d')) }}"
                                    required>
                            @error('due_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="payment_method">Payment Method *</label>
                            <select name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ old('payment_method', $payment->payment_method) == 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                                <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="digital_wallet" {{ old('payment_method', $payment->payment_method) == 'digital_wallet' ? 'selected' : '' }}>Digital Wallet</option>
                            </select>
                            @error('payment_method')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Payment Status *</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ old('status', $payment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ old('status', $payment->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ old('status', $payment->status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Transaction ID Field (this exists in your database) -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="transaction_id">Transaction ID</label>
                            <input type="text" name="transaction_id" id="transaction_id"
                                    class="form-control @error('transaction_id') is-invalid @enderror"
                                    value="{{ old('transaction_id', $payment->transaction_id) }}"
                                    placeholder="Transaction reference number">
                            @error('transaction_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes"
                                class="form-control @error('notes') is-invalid @enderror"
                                rows="3" placeholder="Any additional notes about this payment...">{{ old('notes', $payment->notes) }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Payment Information -->
                <div class="card bg-light mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Payment Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Payment ID:</strong> #{{ $payment->id }}</p>
                                <p><strong>Created:</strong> {{ $payment->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Last Updated:</strong> {{ $payment->updated_at->format('M d, Y h:i A') }}</p>
                                <p>
                                    <strong>Current Status:</strong>
                                    <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : ($payment->status == 'failed' ? 'danger' : 'info')) }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save me-2"></i> Update Payment
                    </button>
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-lg px-5">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                    <button type="button" class="btn btn-danger btn-lg px-5" onclick="confirmDelete()">
                        <i class="fas fa-trash me-2"></i> Delete
                    </button>
                </div>
            </form>

            <!-- Delete Form -->
            <form id="deleteForm" action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const memberSelect = document.getElementById('member_id');
        const planSelect = document.getElementById('plan_id');
        const amountInput = document.getElementById('amount');
        const paymentDateInput = document.getElementById('payment_date');
        const dueDateInput = document.getElementById('due_date');

        // Auto-fill amount when plan is selected
        planSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');

            if (price && !amountInput.value) {
                amountInput.value = parseFloat(price).toFixed(2);
            }
        });

        // Auto-set due date based on plan duration
        function setDueDate() {
            if (paymentDateInput.value && planSelect.value) {
                const selectedOption = planSelect.options[planSelect.selectedIndex];
                const durationDays = selectedOption.getAttribute('data-duration');

                if (durationDays) {
                    const paymentDate = new Date(paymentDateInput.value);
                    paymentDate.setDate(paymentDate.getDate() + parseInt(durationDays));
                    dueDateInput.value = paymentDate.toISOString().split('T')[0];
                }
            }
        }

        paymentDateInput.addEventListener('change', setDueDate);
        planSelect.addEventListener('change', setDueDate);

        // Auto-select plan based on member's current plan
        memberSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const memberPlanId = selectedOption.getAttribute('data-plan');

            if (memberPlanId) {
                for (let i = 0; i < planSelect.options.length; i++) {
                    if (planSelect.options[i].value === memberPlanId) {
                        planSelect.selectedIndex = i;
                        planSelect.dispatchEvent(new Event('change'));
                        break;
                    }
                }
            }
        });

        // Form validation
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const amount = parseFloat(amountInput.value);
            if (amount <= 0) {
                e.preventDefault();
                alert('Please enter a valid amount greater than 0.');
                amountInput.focus();
                return false;
            }

            if (!dueDateInput.value) {
                e.preventDefault();
                alert('Please select a due date.');
                dueDateInput.focus();
                return false;
            }

            const paymentDate = new Date(paymentDateInput.value);
            const dueDate = new Date(dueDateInput.value);

            if (dueDate < paymentDate) {
                e.preventDefault();
                alert('Due date cannot be before payment date.');
                dueDateInput.focus();
                return false;
            }
        });
    });

    function confirmDelete() {
        if (confirm('Are you sure you want to delete this payment? This action cannot be undone.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endpush
