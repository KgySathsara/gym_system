@extends('layouts.app')

@section('title', 'Payments Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-credit-card me-2"></i>Payments Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('payments.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i>Record Payment
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Revenue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            ${{ number_format($revenueStats['total_revenue'], 2) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Monthly Revenue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            ${{ number_format($revenueStats['monthly_revenue'], 2) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Payments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $revenueStats['pending_payments'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Completed Payments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ \App\Models\Payment::where('status', 'completed')->count() }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('payments.index') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" class="form-control" id="search" name="search"
                           value="{{ request('search') }}" placeholder="Search by member name...">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select class="form-select" id="payment_method" name="payment_method">
                        <option value="">All Methods</option>
                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                        <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="digital_wallet" {{ request('payment_method') == 'digital_wallet' ? 'selected' : '' }}>Digital Wallet</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label for="start_date" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date"
                           value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="end_date" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date"
                           value="{{ request('end_date') }}">
                </div>
                <div class="col-md-1 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Payments Table -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Payments List</h5>
    </div>
    <div class="card-body">
        @if($payments->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Payment Date</th>
                            <th>Due Date</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $payment->member->user->profile_image ? asset('storage/' . $payment->member->user->profile_image) : asset('assets/images/default-avatar.png') }}"
                                             alt="{{ $payment->member->user->name }}" class="rounded-circle" width="35" height="35">
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0">{{ $payment->member->user->name }}</h6>
                                        <small class="text-muted">{{ $payment->member->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $payment->plan->name }}</span>
                            </td>
                            <td>
                                <strong>${{ number_format($payment->amount, 2) }}</strong>
                            </td>
                            <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                            <td>
                                <span class="{{ $payment->due_date->isPast() && $payment->status == 'pending' ? 'text-danger' : '' }}">
                                    {{ $payment->due_date->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary text-capitalize">{{ $payment->payment_method }}</span>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'completed' => 'success',
                                        'failed' => 'danger',
                                        'refunded' => 'info'
                                    ];
                                @endphp
                                <span class="badge bg-{{ $statusColors[$payment->status] }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm table-actions">
                                    <!-- View Invoice Button -->
                                    <a href="{{ route('payments.invoice', $payment->id) }}"
                                    class="btn btn-info" data-bs-toggle="tooltip" title="View Invoice">
                                        <i class="fas fa-receipt"></i>
                                    </a>

                                    <!-- Download Invoice Button -->
                                    <a href="{{ route('payments.invoice.download', $payment->id) }}"
                                    class="btn btn-success" data-bs-toggle="tooltip" title="Download PDF">
                                        <i class="fas fa-download"></i>
                                    </a>

                                    <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-info"
                                    data-bs-toggle="tooltip" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning"
                                    data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                data-bs-toggle="tooltip" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this payment?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <p class="mb-0">Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} entries</p>
                </div>
                <div>
                    {{ $payments->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Payments Found</h4>
                <p class="text-muted">There are no payments matching your criteria.</p>
                <a href="{{ route('payments.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i>Record First Payment
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
