@extends('layouts.app')

@section('title', 'Member Details')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user me-2"></i>Member Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
            <a href="{{ route('members.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <!-- Profile Card -->
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">Profile Information</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ $member->user->profile_image ? asset('storage/' . $member->user->profile_image) : asset('assets/images/default-avatar.png') }}"
                     alt="{{ $member->user->name }}" class="rounded-circle mb-3" width="120" height="120">
                <h4>{{ $member->user->name }}</h4>
                <p class="text-muted">Member ID: {{ $member->id }}</p>

                <div class="d-grid gap-2">
                    <span class="badge bg-{{ $member->status == 'active' ? 'success' : ($member->status == 'inactive' ? 'warning' : 'danger') }} fs-6">
                        {{ ucfirst($member->status) }} Member
                    </span>
                </div>
            </div>
        </div>

        <!-- Membership Info -->
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-id-card me-2"></i>Membership Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Plan:</strong>
                    <span class="badge bg-primary float-end">{{ $member->plan->name }}</span>
                </div>
                <div class="mb-2">
                    <strong>Price:</strong>
                    <span class="float-end">${{ number_format($member->plan->price, 2) }}/month</span>
                </div>
                <div class="mb-2">
                    <strong>Join Date:</strong>
                    <span class="float-end">{{ $member->join_date->format('M d, Y') }}</span>
                </div>
                <div class="mb-2">
                    <strong>Expiry Date:</strong>
                    <span class="float-end {{ $member->expiry_date->isPast() ? 'text-danger' : 'text-success' }}">
                        {{ $member->expiry_date->format('M d, Y') }}
                    </span>
                </div>
                <div class="mb-2">
                    <strong>Trainer:</strong>
                    <span class="float-end">
                        @if($member->trainer)
                            <span class="badge bg-info">{{ $member->trainer->user->name }}</span>
                        @else
                            <span class="badge bg-secondary">No Trainer</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Personal Information -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Personal Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Email:</th>
                                <td>{{ $member->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone:</th>
                                <td>{{ $member->user->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth:</th>
                                <td>{{ $member->user->date_of_birth ? $member->user->date_of_birth->format('M d, Y') : 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm">
                            <tr>
                                <th width="40%">Height:</th>
                                <td>{{ $member->height ? $member->height . ' cm' : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Weight:</th>
                                <td>{{ $member->weight ? $member->weight . ' kg' : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>BMI:</th>
                                <td>
                                    @if($member->height && $member->weight)
                                        @php
                                            $bmi = $member->weight / (($member->height / 100) * ($member->height / 100));
                                        @endphp
                                        {{ number_format($bmi, 1) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <strong>Address:</strong>
                        <p class="mb-0">{{ $member->user->address ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Health & Fitness -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-heartbeat me-2"></i>Health & Fitness Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6>Medical Conditions</h6>
                        <p class="text-muted">{{ $member->medical_conditions ?: 'No medical conditions reported.' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6>Fitness Goals</h6>
                        <p class="text-muted">{{ $member->fitness_goals ?: 'No fitness goals specified.' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <h4>{{ $member->payments->count() }}</h4>
                        <p class="mb-0">Total Payments</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-success text-white text-center">
                    <div class="card-body">
                        <h4>{{ $member->attendances->count() }}</h4>
                        <p class="mb-0">Total Visits</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-info text-white text-center">
                    <div class="card-body">
                        <h4>{{ $member->workoutPlans->count() }}</h4>
                        <p class="mb-0">Workout Plans</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>Recent Payments</h6>
            </div>
            <div class="card-body">
                @if($member->payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($member->payments->take(5) as $payment)
                                <tr>
                                    <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                    <td>${{ number_format($payment->amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $payment->status == 'completed' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No payment history.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Recent Attendance</h6>
            </div>
            <div class="card-body">
                @if($member->attendances->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Check-in</th>
                                    <th>Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($member->attendances()->latest()->take(5)->get() as $attendance)
                                <tr>
                                    <td>{{ $attendance->date->format('M d, Y') }}</td>
                                    <td>{{ $attendance->check_in->format('h:i A') }}</td>
                                    <td>
                                        @if($attendance->workout_duration)
                                            {{ $attendance->workout_duration }} mins
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">No attendance records.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
