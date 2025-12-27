@extends('layouts.app')

@section('title', 'Record Attendance')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-calendar-plus me-2"></i>Record Attendance</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Attendance
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-check me-2"></i>Record Member Attendance</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('attendance.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="member_id" class="form-label">Member <span class="text-danger">*</span></label>
                            <select class="form-select @error('member_id') is-invalid @enderror" id="member_id" name="member_id" required>
                                <option value="">Select a Member</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}"
                                        {{ old('member_id', request('member_id')) == $member->id ? 'selected' : '' }}>
                                        {{ $member->user->name }} - {{ $member->plan->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('member_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror"
                                   id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="check_in" class="form-label">Check-in Time <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('check_in') is-invalid @enderror"
                                   id="check_in" name="check_in" value="{{ old('check_in', date('H:i')) }}" required>
                            @error('check_in')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="check_out" class="form-label">Check-out Time</label>
                            <input type="time" class="form-control @error('check_out') is-invalid @enderror"
                                   id="check_out" name="check_out" value="{{ old('check_out') }}">
                            @error('check_out')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Leave empty if member is still in gym.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="workout_type" class="form-label">Workout Type</label>
                            <select class="form-select @error('workout_type') is-invalid @enderror" id="workout_type" name="workout_type">
                                <option value="">Select Workout Type</option>
                                <option value="cardio" {{ old('workout_type') == 'cardio' ? 'selected' : '' }}>Cardio</option>
                                <option value="strength" {{ old('workout_type') == 'strength' ? 'selected' : '' }}>Strength Training</option>
                                <option value="yoga" {{ old('workout_type') == 'yoga' ? 'selected' : '' }}>Yoga</option>
                                <option value="pilates" {{ old('workout_type') == 'pilates' ? 'selected' : '' }}>Pilates</option>
                                <option value="crossfit" {{ old('workout_type') == 'crossfit' ? 'selected' : '' }}>CrossFit</option>
                                <option value="swimming" {{ old('workout_type') == 'swimming' ? 'selected' : '' }}>Swimming</option>
                                <option value="dance" {{ old('workout_type') == 'dance' ? 'selected' : '' }}>Dance</option>
                                <option value="mixed" {{ old('workout_type') == 'mixed' ? 'selected' : '' }}>Mixed</option>
                            </select>
                            @error('workout_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="workout_duration" class="form-label">Workout Duration (minutes)</label>
                            <input type="number" class="form-control @error('workout_duration') is-invalid @enderror"
                                   id="workout_duration" name="workout_duration" value="{{ old('workout_duration') }}"
                                   min="1" placeholder="e.g., 60">
                            @error('workout_duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Automatically calculated if check-out time is provided.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror"
                                  id="notes" name="notes" rows="3"
                                  placeholder="Any additional notes about the workout session...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="reset" class="btn btn-secondary me-md-2">
                            <i class="fas fa-undo me-1"></i>Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Record Attendance
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Quick Check-in -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Check-in</h6>
            </div>
            <div class="card-body">
                <p class="text-muted">Quickly check in active members who haven't checked in today.</p>

                @php
                    $activeMembersNotCheckedIn = \App\Models\Member::where('status', 'active')
                        ->whereDoesntHave('attendances', function($query) {
                            $query->whereDate('date', today());
                        })
                        ->with('user')
                        ->take(5)
                        ->get();
                @endphp

                @if($activeMembersNotCheckedIn->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($activeMembersNotCheckedIn as $member)
                        <a href="javascript:void(0)" class="list-group-item list-group-item-action quick-checkin"
                           data-member-id="{{ $member->id }}" data-member-name="{{ $member->user->name }}">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ $member->user->profile_image ? asset('storage/' . $member->user->profile_image) : asset('assets/images/default-avatar.png') }}"
                                         alt="{{ $member->user->name }}" class="rounded-circle" width="35" height="35">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">{{ $member->user->name }}</h6>
                                    <small class="text-muted">{{ $member->plan->name }}</small>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-sign-in-alt text-success"></i>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                        <p class="text-muted mb-0">All active members have checked in today.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Today's Stats -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Today's Stats</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-2">
                            <h5 class="text-primary mb-1">{{ \App\Models\Attendance::whereDate('date', today())->count() }}</h5>
                            <small class="text-muted">Total Check-ins</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-2">
                            <h5 class="text-success mb-1">{{ \App\Models\Attendance::whereDate('date', today())->whereNotNull('check_out')->count() }}</h5>
                            <small class="text-muted">Checked Out</small>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-2">
                            <h5 class="text-warning mb-1">{{ \App\Models\Attendance::whereDate('date', today())->whereNull('check_out')->count() }}</h5>
                            <small class="text-muted">Currently In Gym</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-2">
                            <h5 class="text-info mb-1">{{ \App\Models\Member::where('status', 'active')->count() - \App\Models\Attendance::whereDate('date', today())->count() }}</h5>
                            <small class="text-muted">Haven't Checked In</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips -->
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-lightbulb me-2"></i>Tips</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><small>💡 Use quick check-in for faster member check-ins</small></li>
                    <li class="mb-2"><small>💡 Check-out time is optional for ongoing sessions</small></li>
                    <li class="mb-2"><small>💡 Duration auto-calculates when check-out is provided</small></li>
                    <li><small>💡 Track workout types for better member insights</small></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.quick-checkin {
    cursor: pointer;
    transition: background-color 0.2s;
}
.quick-checkin:hover {
    background-color: rgba(40, 167, 69, 0.1) !important;
}
</style>
@endpush

@push('scripts')
<script>
    // Quick check-in functionality
    document.querySelectorAll('.quick-checkin').forEach(item => {
        item.addEventListener('click', function() {
            const memberId = this.getAttribute('data-member-id');
            const memberName = this.getAttribute('data-member-name');

            // Set the member in the form
            document.getElementById('member_id').value = memberId;

            // Show success message
            showAlert(`Quick check-in ready for ${memberName}. Complete the form and submit.`, 'success');

            // Scroll to form
            document.getElementById('member_id').scrollIntoView({ behavior: 'smooth' });
        });
    });

    // Auto-calculate duration when check-out time is provided
    document.getElementById('check_out').addEventListener('change', function() {
        const checkIn = document.getElementById('check_in').value;
        const checkOut = this.value;
        const durationField = document.getElementById('workout_duration');

        if (checkIn && checkOut) {
            const [inHours, inMinutes] = checkIn.split(':').map(Number);
            const [outHours, outMinutes] = checkOut.split(':').map(Number);

            const checkInTime = new Date();
            checkInTime.setHours(inHours, inMinutes, 0, 0);

            const checkOutTime = new Date();
            checkOutTime.setHours(outHours, outMinutes, 0, 0);

            // Calculate difference in minutes
            const diffMs = checkOutTime - checkInTime;
            const diffMinutes = Math.round(diffMs / (1000 * 60));

            if (diffMinutes > 0) {
                durationField.value = diffMinutes;
                showAlert(`Workout duration calculated: ${diffMinutes} minutes`, 'info');
            } else {
                showAlert('Check-out time must be after check-in time', 'warning');
                this.value = '';
                durationField.value = '';
            }
        }
    });

    // Validate check-out time
    document.querySelector('form').addEventListener('submit', function(e) {
        const checkIn = document.getElementById('check_in').value;
        const checkOut = document.getElementById('check_out').value;

        if (checkOut && checkIn >= checkOut) {
            e.preventDefault();
            showAlert('Check-out time must be after check-in time', 'danger');
            document.getElementById('check_out').focus();
        }
    });

    // Alert function
    function showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show mt-3`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Remove existing alerts
        document.querySelectorAll('.alert').forEach(alert => alert.remove());

        // Insert after the form
        document.querySelector('form').parentNode.insertBefore(alertDiv, document.querySelector('form').nextSibling);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Auto-focus on member select
    document.addEventListener('DOMContentLoaded', function() {
        @if(request('member_id'))
            document.getElementById('member_id').focus();
        @else
            document.getElementById('member_id').focus();
        @endif
    });
</script>
@endpush
