@extends('layouts.app')

@section('title', 'Plan Details - ' . $plan->name)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-clipboard-list me-2"></i>Plan Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('plans.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Plans
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Plan Information Card -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Plan Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Plan Name:</th>
                                <td><strong>{{ $plan->name }}</strong></td>
                            </tr>
                            <tr>
                                <th>Price:</th>
                                <td>
                                    <span class="h5 text-success">${{ number_format($plan->price, 2) }}</span>
                                    <small class="text-muted">per {{ $plan->duration_days }} days</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Duration:</th>
                                <td>{{ $plan->duration_days }} days</td>
                            </tr>
                            <tr>
                                <th>Sessions/Week:</th>
                                <td>{{ $plan->sessions_per_week }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Status:</th>
                                <td>
                                    <span class="badge bg-{{ $plan->is_active ? 'success' : 'secondary' }}">
                                        {{ $plan->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Includes Trainer:</th>
                                <td>
                                    <span class="badge bg-{{ $plan->has_trainer ? 'success' : 'secondary' }}">
                                        {{ $plan->has_trainer ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $plan->created_at->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated:</th>
                                <td>{{ $plan->updated_at->format('M d, Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($plan->description)
                <div class="mt-3">
                    <h6>Description:</h6>
                    <p class="mb-0">{{ $plan->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Plan Features -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-list-check me-2"></i>Plan Features</h5>
            </div>
            <div class="card-body">
                @if($plan->features && is_array($plan->features) && count($plan->features) > 0)
                    <div class="row">
                        @foreach($plan->features as $feature)
                        <div class="col-md-6 mb-2">
                            <i class="fas fa-check text-success me-2"></i>{{ $feature }}
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-list-alt fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No features specified for this plan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Plan Statistics -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Plan Statistics</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="display-4 text-primary">{{ $plan->members->count() }}</div>
                    <p class="text-muted">Active Members</p>
                </div>

                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-2">
                            <h5 class="text-success mb-1">{{ $plan->payments->where('status', 'completed')->count() }}</h5>
                            <small class="text-muted">Completed Payments</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-2">
                            <h5 class="text-warning mb-1">{{ $plan->payments->where('status', 'pending')->count() }}</h5>
                            <small class="text-muted">Pending Payments</small>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <h6>Monthly Revenue:</h6>
                    <div class="progress mb-2">
                        @php
                            $monthlyRevenue = $plan->payments()
                                ->where('status', 'completed')
                                ->whereYear('payment_date', now()->year)
                                ->whereMonth('payment_date', now()->month)
                                ->sum('amount');
                            $maxRevenue = max($monthlyRevenue, $plan->price * 10); // Estimate max
                            $percentage = $maxRevenue > 0 ? ($monthlyRevenue / $maxRevenue) * 100 : 0;
                        @endphp
                        <div class="progress-bar bg-success" role="progressbar"
                             style="width: {{ $percentage }}%"
                             aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <p class="mb-0 text-center">
                        <strong>${{ number_format($monthlyRevenue, 2) }}</strong>
                        <small class="text-muted">this month</small>
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>Edit Plan
                    </a>

                    @if($plan->is_active)
                        <form action="{{ route('plans.toggle-status', $plan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-warning w-100">
                                <i class="fas fa-pause me-1"></i>Deactivate Plan
                            </button>
                        </form>
                    @else
                        <form action="{{ route('plans.toggle-status', $plan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-success w-100">
                                <i class="fas fa-play me-1"></i>Activate Plan
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('members.create') }}?plan_id={{ $plan->id }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus me-1"></i>Add Member to This Plan
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Members -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Recent Members</h5>
            </div>
            <div class="card-body">
                @if($plan->members->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($plan->members()->latest()->take(5)->get() as $member)
                        <a href="{{ route('members.show', $member->id) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ $member->user->profile_image ? asset('storage/' . $member->user->profile_image) : asset('assets/images/default-avatar.png') }}"
                                         alt="{{ $member->user->name }}" class="rounded-circle" width="35" height="35">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">{{ $member->user->name }}</h6>
                                    <small class="text-muted">
                                        Joined {{ $member->join_date->format('M d, Y') }}
                                    </small>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-{{ $member->status == 'active' ? 'success' : ($member->status == 'inactive' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @if($plan->members->count() > 5)
                        <div class="text-center mt-3">
                            <a href="{{ route('members.index') }}?plan_id={{ $plan->id }}" class="btn btn-sm btn-outline-primary">
                                View All {{ $plan->members->count() }} Members
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-users-slash fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No members on this plan yet.</p>
                        <a href="{{ route('members.create') }}?plan_id={{ $plan->id }}" class="btn btn-sm btn-primary mt-2">
                            <i class="fas fa-user-plus me-1"></i>Add First Member
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Danger Zone -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Danger Zone</h5>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h6 class="mb-1">Delete This Plan</h6>
                        <p class="text-muted mb-0">
                            Once deleted, this plan cannot be recovered. Members on this plan will need to be assigned to a different plan.
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <form action="{{ route('plans.destroy', $plan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this plan? This action cannot be undone.')">
                                <i class="fas fa-trash me-1"></i>Delete Plan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
}
.list-group-item:hover {
    background-color: rgba(0, 0, 0, 0.03);
}
</style>
@endpush
