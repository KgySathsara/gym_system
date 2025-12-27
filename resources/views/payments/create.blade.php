@extends('layouts.app')

@section('title', 'Record New Payment')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-plus-circle me-2"></i>Record New Payment
            </h3>
            {{-- <div class="card-tools">
                <a href="{{ route('payments.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to Payments
                </a>
            </div> --}}
        </div>
        <div class="card-body">
            <form action="{{ route('payments.store') }}" method="POST" id="paymentForm">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="member_id">Member *</label>
                            <select name="member_id" id="member_id" class="form-control @error('member_id') is-invalid @enderror" required>
                                <option value="">Select Member</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('member_id') == $member->id ? 'selected' : '' }}
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
                                        {{ old('plan_id') == $plan->id ? 'selected' : '' }}
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
                                    value="{{ old('amount') }}"
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
                                    value="{{ old('payment_date', now()->format('Y-m-d')) }}"
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
                                    value="{{ old('due_date') }}"
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
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="digital_wallet" {{ old('payment_method') == 'digital_wallet' ? 'selected' : '' }}>Digital Wallet</option>
                                <option value="check" {{ old('payment_method') == 'check' ? 'selected' : '' }}>Check</option>
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
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Fields for Different Payment Methods -->
                <div id="card_fields" class="payment-method-fields" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="card_last_four">Card Last 4 Digits</label>
                                <input type="text" name="card_last_four" id="card_last_four"
                                        class="form-control @error('card_last_four') is-invalid @enderror"
                                        value="{{ old('card_last_four') }}"
                                        maxlength="4" placeholder="1234">
                                @error('card_last_four')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="card_type">Card Type</label>
                                <select name="card_type" id="card_type" class="form-control @error('card_type') is-invalid @enderror">
                                    <option value="">Select Card Type</option>
                                    <option value="visa" {{ old('card_type') == 'visa' ? 'selected' : '' }}>Visa</option>
                                    <option value="mastercard" {{ old('card_type') == 'mastercard' ? 'selected' : '' }}>MasterCard</option>
                                    <option value="amex" {{ old('card_type') == 'amex' ? 'selected' : '' }}>American Express</option>
                                    <option value="discover" {{ old('card_type') == 'discover' ? 'selected' : '' }}>Discover</option>
                                </select>
                                @error('card_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div id="bank_transfer_fields" class="payment-method-fields" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" name="bank_name" id="bank_name"
                                        class="form-control @error('bank_name') is-invalid @enderror"
                                        value="{{ old('bank_name') }}"
                                        placeholder="e.g., Chase Bank">
                                @error('bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transaction_id">Transaction ID</label>
                                <input type="text" name="transaction_id" id="transaction_id"
                                        class="form-control @error('transaction_id') is-invalid @enderror"
                                        value="{{ old('transaction_id') }}"
                                        placeholder="Bank transaction reference">
                                @error('transaction_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div id="digital_wallet_fields" class="payment-method-fields" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="wallet_type">Wallet Type</label>
                                <select name="wallet_type" id="wallet_type" class="form-control @error('wallet_type') is-invalid @enderror">
                                    <option value="">Select Wallet Type</option>
                                    <option value="paypal" {{ old('wallet_type') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                    <option value="google_pay" {{ old('wallet_type') == 'google_pay' ? 'selected' : '' }}>Google Pay</option>
                                    <option value="apple_pay" {{ old('wallet_type') == 'apple_pay' ? 'selected' : '' }}>Apple Pay</option>
                                    <option value="other" {{ old('wallet_type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('wallet_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="wallet_transaction_id">Transaction ID</label>
                                <input type="text" name="wallet_transaction_id" id="wallet_transaction_id"
                                        class="form-control @error('wallet_transaction_id') is-invalid @enderror"
                                        value="{{ old('wallet_transaction_id') }}"
                                        placeholder="Digital wallet transaction ID">
                                @error('wallet_transaction_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes"
                                class="form-control @error('notes') is-invalid @enderror"
                                rows="3" placeholder="Any additional notes about this payment...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Summary Section -->
                <div class="card bg-light mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-receipt me-2"></i>Payment Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Member:</strong> <span id="summary_member">-</span></p>
                                <p><strong>Plan:</strong> <span id="summary_plan">-</span></p>
                                <p><strong>Amount:</strong> $<span id="summary_amount">0.00</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Payment Date:</strong> <span id="summary_payment_date">{{ now()->format('M d, Y') }}</span></p>
                                <p><strong>Due Date:</strong> <span id="summary_due_date">-</span></p>
                                <p><strong>Status:</strong> <span id="summary_status">Pending</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="fas fa-save me-2"></i> Record Payment
                    </button>
                    <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-lg px-5">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .payment-method-fields {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin: 10px 0;
        border-left: 4px solid #007bff;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const memberSelect = document.getElementById('member_id');
        const planSelect = document.getElementById('plan_id');
        const amountInput = document.getElementById('amount');
        const paymentDateInput = document.getElementById('payment_date');
        const dueDateInput = document.getElementById('due_date');
        const statusSelect = document.getElementById('status');
        const paymentMethodSelect = document.getElementById('payment_method');

        // Summary elements
        const summaryMember = document.getElementById('summary_member');
        const summaryPlan = document.getElementById('summary_plan');
        const summaryAmount = document.getElementById('summary_amount');
        const summaryPaymentDate = document.getElementById('summary_payment_date');
        const summaryDueDate = document.getElementById('summary_due_date');
        const summaryStatus = document.getElementById('summary_status');

        // Auto-fill amount when plan is selected
        planSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');

            if (price && !amountInput.value) {
                amountInput.value = parseFloat(price).toFixed(2);
            }

            updateSummary();
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

        // Update summary in real-time
        function updateSummary() {
            // Member
            const memberText = memberSelect.options[memberSelect.selectedIndex]?.text || '-';
            summaryMember.textContent = memberText.split(' (')[0]; // Remove ID part

            // Plan
            const planText = planSelect.options[planSelect.selectedIndex]?.text || '-';
            summaryPlan.textContent = planText.split(' - $')[0]; // Remove price part

            // Amount
            summaryAmount.textContent = amountInput.value ? parseFloat(amountInput.value).toFixed(2) : '0.00';

            // Payment Date
            if (paymentDateInput.value) {
                const paymentDate = new Date(paymentDateInput.value);
                summaryPaymentDate.textContent = paymentDate.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
            }

            // Due Date
            if (dueDateInput.value) {
                const dueDate = new Date(dueDateInput.value);
                summaryDueDate.textContent = dueDate.toLocaleDateString('en-US', {
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });
            }

            // Status
            summaryStatus.textContent = statusSelect.options[statusSelect.selectedIndex]?.text || 'Pending';
        }

        // Show/hide payment method specific fields
        function togglePaymentMethodFields() {
            // Hide all fields first
            document.querySelectorAll('.payment-method-fields').forEach(field => {
                field.style.display = 'none';
            });

            // Show fields for selected payment method
            const selectedMethod = paymentMethodSelect.value;
            if (selectedMethod === 'card') {
                document.getElementById('card_fields').style.display = 'block';
            } else if (selectedMethod === 'bank_transfer') {
                document.getElementById('bank_transfer_fields').style.display = 'block';
            } else if (selectedMethod === 'digital_wallet') {
                document.getElementById('digital_wallet_fields').style.display = 'block';
            }
        }

        paymentMethodSelect.addEventListener('change', togglePaymentMethodFields);

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

        // Update summary when any field changes
        memberSelect.addEventListener('change', updateSummary);
        planSelect.addEventListener('change', updateSummary);
        amountInput.addEventListener('input', updateSummary);
        paymentDateInput.addEventListener('change', updateSummary);
        dueDateInput.addEventListener('change', updateSummary);
        statusSelect.addEventListener('change', updateSummary);

        // Initialize
        togglePaymentMethodFields();
        updateSummary();
        setDueDate();

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
</script>
@endpush
