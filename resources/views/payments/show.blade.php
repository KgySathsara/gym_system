@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-primary mb-1">
                <i class="fas fa-receipt me-2"></i>Payment Details
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Payment #{{ $payment->id }}</li>
                </ol>
            </nav>
        </div>
        <div class="btn-group">
            <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Payments
            </a>
            <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-outline-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
        </div>
    </div>

    <!-- Payment Details Card -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Payment Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th class="text-muted" width="40%">Payment ID:</th>
                                    <td class="fw-bold">#{{ $payment->id }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Member:</th>
                                    <td>
                                        @if($payment->member)
                                            <a href="{{ route('members.show', $payment->member->id) }}" class="text-decoration-none">
                                                {{ $payment->member->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Plan:</th>
                                    <td>
                                        @if($payment->plan)
                                            <span class="badge bg-primary">{{ $payment->plan->name }}</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Amount:</th>
                                    <td class="fw-bold text-success fs-5">${{ number_format($payment->amount, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th class="text-muted" width="40%">Payment Date:</th>
                                    <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Due Date:</th>
                                    <td>{{ $payment->due_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Payment Method:</th>
                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ ucfirst($payment->payment_method) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Status:</th>
                                    <td>
                                        <span class="badge
                                            @if($payment->status == 'completed') bg-success
                                            @elseif($payment->status == 'pending') bg-warning text-dark
                                            @elseif($payment->status == 'failed') bg-danger
                                            @else bg-secondary @endif">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($payment->notes)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-muted mb-2">Notes:</h6>
                            <div class="bg-light rounded p-3">
                                {{ $payment->notes }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Transaction History -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Transaction History
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="fw-bold mb-1">Payment Created</h6>
                                <p class="text-muted mb-1">Payment record was created</p>
                                <small class="text-muted">{{ $payment->created_at->format('M d, Y h:i A') }}</small>
                            </div>
                        </div>
                        @if($payment->updated_at != $payment->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="fw-bold mb-1">Payment Updated</h6>
                                <p class="text-muted mb-1">Payment details were modified</p>
                                <small class="text-muted">{{ $payment->updated_at->format('M d, Y h:i A') }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Actions Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-cogs me-2 text-primary"></i>
                        Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <!-- Status Update Form - Only show if you have the route -->
                        @if($payment->status == 'pending')
                        <form action="{{ route('payments.update', $payment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-success w-100 mb-2">
                                <i class="fas fa-check-circle me-1"></i>Mark as Completed
                            </button>
                        </form>
                        @endif

                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-outline-warning mb-2">
                            <i class="fas fa-edit me-1"></i>Edit Payment
                        </a>

                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100"
                                    onclick="return confirm('Are you sure you want to delete this payment?')">
                                <i class="fas fa-trash me-1"></i>Delete Payment
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        Payment Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Amount Paid:</span>
                        <span class="fw-bold text-success">${{ number_format($payment->amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Payment Method:</span>
                        <span class="badge bg-info text-dark">{{ ucfirst($payment->payment_method) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Days Remaining:</span>
                        <span class="fw-bold
                            @if($payment->due_date->diffInDays(now(), false) > 0) text-danger
                            @elseif($payment->due_date->diffInDays(now(), false) < 7) text-warning
                            @else text-success @endif">
                            {{ $payment->due_date->diffInDays(now(), false) }} days
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-content {
    padding-bottom: 10px;
    border-bottom: 1px solid #e9ecef;
}

.timeline-item:last-child .timeline-content {
    border-bottom: none;
    padding-bottom: 0;
}

.card {
    border-radius: 12px;
}

.badge {
    font-size: 0.75em;
}

.table-borderless th {
    font-weight: 500;
}
</style>
@endpush
