@extends('layouts.app')

@section('title', 'Attendance Details - ' . $attendance->member->user->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-eye me-2"></i>Attendance Details
                    </h3>
                    {{-- <div class="card-tools">
                        <a href="{{ route('attendance.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Member Information -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-user me-2"></i>Member Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $attendance->member->user->profile_image ? asset('storage/' . $attendance->member->user->profile_image) : asset('assets/images/default-avatar.png') }}"
                                                 alt="{{ $attendance->member->user->name }}"
                                                 class="rounded-circle" width="80" height="80">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h4 class="mb-1">{{ $attendance->member->user->name }}</h4>
                                            <p class="text-muted mb-1">{{ $attendance->member->user->email }}</p>
                                            <span class="badge bg-success">{{ $attendance->member->member_type }}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Member ID</small>
                                            <p class="mb-2"><strong>#{{ $attendance->member->id }}</strong></p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Phone</small>
                                            <p class="mb-2"><strong>{{ $attendance->member->user->phone ?? 'N/A' }}</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Attendance Summary -->
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Attendance Summary</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6 mb-3">
                                            <div class="border rounded p-3">
                                                <i class="fas fa-sign-in-alt fa-2x text-success mb-2"></i>
                                                <h5 class="mb-1">{{ $attendance->check_in->format('h:i A') }}</h5>
                                                <small class="text-muted">Check-in Time</small>
                                            </div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <div class="border rounded p-3">
                                                @if($attendance->check_out)
                                                    <i class="fas fa-sign-out-alt fa-2x text-danger mb-2"></i>
                                                    <h5 class="mb-1">{{ $attendance->check_out->format('h:i A') }}</h5>
                                                @else
                                                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                                    <h5 class="mb-1">Not Checked Out</h5>
                                                @endif
                                                <small class="text-muted">Check-out Time</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="border rounded p-3">
                                                <i class="fas fa-dumbbell fa-2x text-primary mb-2"></i>
                                                @if($attendance->workout_duration)
                                                    <h5 class="mb-1">{{ $attendance->workout_duration }} min</h5>
                                                @else
                                                    <h5 class="mb-1">N/A</h5>
                                                @endif
                                                <small class="text-muted">Workout Duration</small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="border rounded p-3">
                                                <i class="fas fa-calendar-day fa-2x text-info mb-2"></i>
                                                <h5 class="mb-1">{{ $attendance->date->format('M d, Y') }}</h5>
                                                <small class="text-muted">Attendance Date</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Workout Details -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-dumbbell me-2"></i>Workout Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Workout Type</label>
                                            <div>
                                                @if($attendance->workout_type)
                                                    <span class="badge bg-primary text-capitalize fs-6">{{ $attendance->workout_type }}</span>
                                                @else
                                                    <span class="text-muted">Not specified</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted">Workout Duration</label>
                                            <div>
                                                @if($attendance->workout_duration)
                                                    <h5 class="text-primary">{{ $attendance->workout_duration }} minutes</h5>
                                                @else
                                                    <span class="text-muted">Not recorded</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if($attendance->notes)
                                    <div class="mb-3">
                                        <label class="form-label text-muted">Additional Notes</label>
                                        <div class="border rounded p-3 bg-light">
                                            {{ $attendance->notes }}
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Timeline -->
                                    <div class="mt-4">
                                        <label class="form-label text-muted">Attendance Timeline</label>
                                        <div class="timeline">
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-success"></div>
                                                <div class="timeline-content">
                                                    <h6 class="mb-1">Checked In</h6>
                                                    <p class="text-muted mb-0">{{ $attendance->check_in->format('h:i A') }} • {{ $attendance->date->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            @if($attendance->check_out)
                                            <div class="timeline-item">
                                                <div class="timeline-marker bg-danger"></div>
                                                <div class="timeline-content">
                                                    <h6 class="mb-1">Checked Out</h6>
                                                    <p class="text-muted mb-0">{{ $attendance->check_out->format('h:i A') }} • {{ $attendance->date->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-warning btn-lg">
                                            <i class="fas fa-edit me-2"></i>Edit Attendance
                                        </a>
                                        <a href="{{ route('members.show', $attendance->member_id) }}" class="btn btn-info btn-lg">
                                            <i class="fas fa-user me-2"></i>View Member Profile
                                        </a>
                                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary btn-lg">
                                            <i class="fas fa-list me-2"></i>Back to List
                                        </a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="d-grid">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-lg"
                                                    onclick="return confirm('Are you sure you want to delete this attendance record? This action cannot be undone.')">
                                                <i class="fas fa-trash me-2"></i>Delete Record
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Record Information -->
                                    <div class="mt-4 pt-3 border-top">
                                        <h6 class="text-muted mb-3">Record Information</h6>
                                        <div class="small">
                                            <p class="mb-1">
                                                <strong>Created:</strong>
                                                {{ $attendance->created_at->format('M d, Y h:i A') }}
                                            </p>
                                            <p class="mb-1">
                                                <strong>Last Updated:</strong>
                                                {{ $attendance->updated_at->format('M d, Y h:i A') }}
                                            </p>
                                            <p class="mb-0">
                                                <strong>Record ID:</strong>
                                                #{{ $attendance->id }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Add any additional JavaScript if needed
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Attendance details page loaded');
    });
</script>
@endpush
