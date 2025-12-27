@extends('layouts.app')

@section('title', 'Payment Invoice')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="fas fa-receipt me-2"></i>Payment Invoice
            </h3>
            {{-- <div class="card-tools">
                <div class="btn-group">
                    <a href="{{ route('payments.invoice.download', $payment->id) }}"
                       class="btn btn-light btn-sm" target="_blank">
                        <i class="fas fa-download me-1"></i>Download PDF
                    </a>
                    <a href="{{ route('payments.invoice.print', $payment->id) }}"
                       class="btn btn-light btn-sm" target="_blank">
                        <i class="fas fa-print me-1"></i>Print
                    </a>
                    <a href="{{ route('payments.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to Payments
                    </a>
                </div>
            </div> --}}
        </div>
        <div class="card-body">
            <!-- Invoice Header -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4 class="text-primary">GYM MANAGEMENT SYSTEM</h4>
                    <p class="mb-1">123 Fitness Street</p>
                    <p class="mb-1">Sports City, SC 12345</p>
                    <p class="mb-1">Phone: (555) 123-4567</p>
                    <p class="mb-0">Email: info@gymmanagement.com</p>
                </div>
                <div class="col-md-6 text-end">
                    <h2 class="text-success">INVOICE</h2>
                    <p class="mb-1"><strong>Invoice #:</strong> INV-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="mb-1"><strong>Date:</strong> {{ $payment->payment_date->format('F d, Y') }}</p>
                    <p class="mb-1"><strong>Due Date:</strong> {{ $payment->due_date->format('F d, Y') }}</p>
                    <p class="mb-0">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Bill To Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Bill To:</h5>
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="mb-1">{{ $payment->member->user->name }}</h6>
                            <p class="mb-1 text-muted">Member ID: {{ $payment->member->member_id ?? $payment->member->id }}</p>
                            <p class="mb-1">{{ $payment->member->user->email }}</p>
                            @if($payment->member->user->phone)
                                <p class="mb-0">{{ $payment->member->user->phone }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Payment Details:</h5>
                    <div class="card bg-light">
                        <div class="card-body">
                            <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                            <p class="mb-1"><strong>Transaction Date:</strong> {{ $payment->payment_date->format('M d, Y h:i A') }}</p>
                            @if($payment->transaction_id)
                                <p class="mb-0"><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Description</th>
                            <th>Plan Duration</th>
                            <th class="text-end">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <h6 class="mb-1">{{ $payment->plan->name }}</h6>
                                <p class="mb-0 text-muted small">{{ $payment->plan->description ?? 'Gym membership plan' }}</p>
                            </td>
                            <td>{{ $payment->plan->duration_days }} days</td>
                            <td class="text-end">${{ number_format($payment->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-end"><strong>Subtotal:</strong></td>
                            <td class="text-end">${{ number_format($payment->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-end"><strong>Tax (0%):</strong></td>
                            <td class="text-end">$0.00</td>
                        </tr>
                        <tr class="table-success">
                            <td colspan="2" class="text-end"><strong>TOTAL:</strong></td>
                            <td class="text-end"><strong>${{ number_format($payment->amount, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Payment Notes -->
            @if($payment->notes)
            <div class="card border-warning">
                <div class="card-header bg-warning">
                    <h6 class="mb-0"><i class="fas fa-sticky-note me-2"></i>Notes</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $payment->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Terms and Conditions -->
            <div class="mt-4 pt-4 border-top">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Payment Terms:</h6>
                        <p class="small text-muted mb-0">
                            Payment is due by the due date specified above.
                            Late payments may result in membership suspension.
                        </p>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="mt-3">
                            <p class="mb-1">Authorized Signature</p>
                            <div class="border-bottom" style="width: 200px; margin-left: auto;"></div>
                            <p class="small text-muted mt-1">Gym Management System</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <div class="btn-group">
                        <a href="{{ route('payments.invoice.download', $payment->id) }}"
                           class="btn btn-success btn-lg px-4">
                            <i class="fas fa-download me-2"></i>Download PDF
                        </a>
                        <a href="{{ route('payments.invoice.print', $payment->id) }}"
                           class="btn btn-primary btn-lg px-4" target="_blank">
                            <i class="fas fa-print me-2"></i>Print Invoice
                        </a>
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-lg px-4">
                            <i class="fas fa-arrow-left me-2"></i>Back to Payments
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    @media print {
        .btn-group, .card-tools {
            display: none !important;
        }
        .card-header {
            background: #fff !important;
            color: #000 !important;
            border-bottom: 2px solid #000;
        }
    }
</style>
@endpush
