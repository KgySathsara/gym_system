@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Today</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Week</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Month</button>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Members
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_members'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Today's Attendance
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['today_attendances'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Monthly Revenue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            ${{ number_format($stats['revenue_stats']['monthly_revenue'], 2) }}
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
        <div class="card stat-card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Payments
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['revenue_stats']['pending_payments'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats -->
<div class="row mb-4">
    <div class="col-md-3 mb-4">
        <div class="card bg-light">
            <div class="card-body text-center">
                <i class="fas fa-user-tie fa-2x text-primary mb-2"></i>
                <h5>{{ \App\Models\Trainer::count() }}</h5>
                <p class="mb-0">Active Trainers</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-light">
            <div class="card-body text-center">
                <i class="fas fa-clipboard-list fa-2x text-success mb-2"></i>
                <h5>{{ \App\Models\Plan::where('is_active', true)->count() }}</h5>
                <p class="mb-0">Active Plans</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-light">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-2x text-info mb-2"></i>
                <h5>{{ $stats['attendance_stats']['average_daily_attendance'] }}</h5>
                <p class="mb-0">Avg Daily Attendance</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-light">
            <div class="card-body text-center">
                <i class="fas fa-money-bill-wave fa-2x text-warning mb-2"></i>
                <h5>${{ number_format($stats['revenue_stats']['total_revenue'], 2) }}</h5>
                <p class="mb-0">Total Revenue</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-users me-2"></i>Recent Members</h6>
            </div>
            <div class="card-body">
                @if($recentMembers->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Join Date</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentMembers as $member)
                                <tr>
                                    <td>
                                        <strong>{{ $member->user->name }}</strong>
                                    </td>
                                    <td>{{ $member->join_date->format('M d, Y') }}</td>
                                    <td>{{ $member->plan->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $member->is_active ? 'success' : 'danger' }}">
                                            {{ ucfirst($member->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('members.index') }}" class="btn btn-sm btn-primary">View All Members</a>
                    </div>
                @else
                    <p class="text-muted text-center">No members found.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-clock me-2"></i>Pending Payments</h6>
            </div>
            <div class="card-body">
                @if($pendingPayments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingPayments as $payment)
                                <tr>
                                    <td>{{ $payment->member->user->name }}</td>
                                    <td><strong>${{ number_format($payment->amount, 2) }}</strong></td>
                                    <td>
                                        <span class="{{ $payment->due_date->isPast() ? 'text-danger' : '' }}">
                                            {{ $payment->due_date->format('M d, Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('payments.index') }}" class="btn btn-sm btn-warning">View All Payments</a>
                    </div>
                @else
                    <p class="text-muted text-center">No pending payments.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h6 class="m-0 font-weight-bold"><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('members.create') }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-user-plus fa-2x mb-2"></i><br>
                            Add Member
                        </a>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('attendance.create') }}" class="btn btn-outline-success btn-sm w-100">
                            <i class="fas fa-calendar-plus fa-2x mb-2"></i><br>
                            Record Attendance
                        </a>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('payments.create') }}" class="btn btn-outline-info btn-sm w-100">
                            <i class="fas fa-credit-card fa-2x mb-2"></i><br>
                            Add Payment
                        </a>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('attendance.today') }}" class="btn btn-outline-warning btn-sm w-100">
                            <i class="fas fa-list fa-2x mb-2"></i><br>
                            Today's Attendance
                        </a>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('trainers.create') }}" class="btn btn-outline-secondary btn-sm w-100">
                            <i class="fas fa-user-tie fa-2x mb-2"></i><br>
                            Add Trainer
                        </a>
                    </div>
                    <div class="col-md-2 mb-3">
                        <a href="{{ route('plans.create') }}" class="btn btn-outline-dark btn-sm w-100">
                            <i class="fas fa-plus-circle fa-2x mb-2"></i><br>
                            Create Plan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
