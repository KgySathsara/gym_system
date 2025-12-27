@extends('layouts.app')

@section('title', 'Today\'s Attendance')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-calendar-day me-2"></i>Today's Attendance</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i>Record Attendance
            </a>
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>All Records
            </a>
        </div>
    </div>
</div>

<!-- Today's Stats -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white text-center">
            <div class="card-body">
                <h3>{{ $totalCheckins }}</h3>
                <p class="mb-0">Total Check-ins</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <h3>{{ $checkedOut }}</h3>
                <p class="mb-0">Checked Out</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-dark text-center">
            <div class="card-body">
                <h3>{{ $currentlyInGym }}</h3>
                <p class="mb-0">Currently In Gym</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <h3>{{ $notCheckedIn }}</h3>
                <p class="mb-0">Haven't Checked In</p>
            </div>
        </div>
    </div>
</div>

<!-- Today's Attendance Table -->
<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Attendance for {{ now()->format('F d, Y') }}</h5>
    </div>
    <div class="card-body">
        @if($attendances->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Member</th>
                            <th>Check-in Time</th>
                            <th>Check-out Time</th>
                            <th>Duration</th>
                            <th>Workout Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $attendance->member->user->profile_image ? asset('storage/' . $attendance->member->user->profile_image) : asset('assets/images/default-avatar.png') }}"
                                             alt="{{ $attendance->member->user->name }}" class="rounded-circle" width="40" height="40">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-0">{{ $attendance->member->user->name }}</h6>
                                        <small class="text-muted">{{ $attendance->member->plan->name ?? 'No Plan' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success">{{ $attendance->check_in->format('h:i A') }}</span>
                            </td>
                            <td>
                                @if($attendance->check_out)
                                    <span class="badge bg-danger">{{ $attendance->check_out->format('h:i A') }}</span>
                                @else
                                    <span class="badge bg-warning">Still in gym</span>
                                @endif
                            </td>
                            <td>
                                @if($attendance->workout_duration)
                                    <span class="badge bg-info">{{ $attendance->workout_duration }} mins</span>
                                @elseif($attendance->check_out)
                                    @php
                                        $duration = $attendance->check_in->diffInMinutes($attendance->check_out);
                                    @endphp
                                    <span class="badge bg-info">{{ $duration }} mins</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($attendance->workout_type)
                                    <span class="badge bg-secondary text-capitalize">{{ $attendance->workout_type }}</span>
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </td>
                            <td>
                                @if($attendance->check_out)
                                    <span class="badge bg-success">Completed</span>
                                @else
                                    <span class="badge bg-warning text-dark">Active</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    @if(!$attendance->check_out)
                                        <form action="{{ route('attendance.update', $attendance->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="check_out" value="{{ now()->format('H:i') }}">
                                            <button type="submit" class="btn btn-success btn-sm"
                                                    data-bs-toggle="tooltip" title="Check Out"
                                                    onclick="return confirm('Check out {{ $attendance->member->user->name }}?')">
                                                <i class="fas fa-sign-out-alt"></i> Check Out
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-warning btn-sm"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($attendances->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <p class="mb-0">Showing {{ $attendances->firstItem() }} to {{ $attendances->lastItem() }} of {{ $attendances->total() }} entries</p>
                </div>
                <div>
                    {{ $attendances->links() }}
                </div>
            </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No Check-ins Today</h4>
                <p class="text-muted">No members have checked in yet today.</p>
                <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i>Record First Check-in
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Active Members Not Checked In -->
@php
    $activeMembers = \App\Models\Member::where('status', 'active')
        ->whereDoesntHave('attendances', function($query) {
            $query->whereDate('date', today());
        })
        ->with('user')
        ->get();
@endphp

@if($activeMembers->count() > 0)
<div class="card mt-4">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0"><i class="fas fa-user-clock me-2"></i>Active Members Not Checked In Today</h5>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($activeMembers as $member)
            <div class="col-md-3 mb-3">
                <div class="card border-warning">
                    <div class="card-body text-center">
                        <img src="{{ $member->user->profile_image ? asset('storage/' . $member->user->profile_image) : asset('assets/images/default-avatar.png') }}"
                             alt="{{ $member->user->name }}" class="rounded-circle mb-2" width="60" height="60">
                        <h6 class="mb-1">{{ $member->user->name }}</h6>
                        <p class="text-muted mb-1 small">{{ $member->plan->name ?? 'No Plan' }}</p>
                        <a href="{{ route('attendance.create') }}?member_id={{ $member->id }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-sign-in-alt me-1"></i>Check In
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Auto refresh every 30 seconds
    setInterval(function() {
        window.location.reload();
    }, 30000);
</script>
@endpush
