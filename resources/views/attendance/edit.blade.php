@extends('layouts.app')

@section('title', 'Edit Attendance')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Attendance</h3>
                    <div class="card-tools">
                        <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="member_id">Member *</label>
                                    <select name="member_id" id="member_id" class="form-control @error('member_id') is-invalid @enderror" required>
                                        <option value="">Select Member</option>
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}"
                                                {{ $attendance->member_id == $member->id ? 'selected' : '' }}>
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
                                    <label for="date">Date *</label>
                                    <input type="date" name="date" id="date"
                                           class="form-control @error('date') is-invalid @enderror"
                                           value="{{ old('date', $attendance->date->format('Y-m-d')) }}"
                                           required>
                                    @error('date')
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
                                    <label for="check_in">Check In Time</label>
                                    <input type="time" name="check_in" id="check_in"
                                           class="form-control @error('check_in') is-invalid @enderror"
                                           value="{{ old('check_in', $attendance->check_in ? $attendance->check_in->format('H:i') : '') }}">
                                    @error('check_in')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="check_out">Check Out Time</label>
                                    <input type="time" name="check_out" id="check_out"
                                           class="form-control @error('check_out') is-invalid @enderror"
                                           value="{{ old('check_out', $attendance->check_out ? $attendance->check_out->format('H:i') : '') }}">
                                    @error('check_out')
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
                                    <label for="workout_type">Workout Type</label>
                                    <select name="workout_type" id="workout_type" class="form-control @error('workout_type') is-invalid @enderror">
                                        <option value="">Select Workout Type</option>
                                        <option value="cardio" {{ $attendance->workout_type == 'cardio' ? 'selected' : '' }}>Cardio</option>
                                        <option value="strength" {{ $attendance->workout_type == 'strength' ? 'selected' : '' }}>Strength</option>
                                        <option value="yoga" {{ $attendance->workout_type == 'yoga' ? 'selected' : '' }}>Yoga</option>
                                        <option value="crossfit" {{ $attendance->workout_type == 'crossfit' ? 'selected' : '' }}>CrossFit</option>
                                        <option value="swimming" {{ $attendance->workout_type == 'swimming' ? 'selected' : '' }}>Swimming</option>
                                        <option value="dance" {{ $attendance->workout_type == 'dance' ? 'selected' : '' }}>Dance</option>
                                    </select>
                                    @error('workout_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="workout_duration">Workout Duration (minutes)</label>
                                    <input type="number" name="workout_duration" id="workout_duration"
                                           class="form-control @error('workout_duration') is-invalid @enderror"
                                           value="{{ old('workout_duration', $attendance->workout_duration) }}"
                                           min="1" max="480" placeholder="Duration in minutes">
                                    @error('workout_duration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes"
                                      class="form-control @error('notes') is-invalid @enderror"
                                      rows="3" placeholder="Any additional notes...">{{ old('notes', $attendance->notes) }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Attendance
                            </button>
                            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-calculate hours worked when check-in/check-out times change
    document.addEventListener('DOMContentLoaded', function() {
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');
        const workoutDurationInput = document.getElementById('workout_duration');

        function calculateWorkoutDuration() {
            if (checkInInput.value && checkOutInput.value) {
                const checkIn = new Date(`2000-01-01T${checkInInput.value}`);
                const checkOut = new Date(`2000-01-01T${checkOutInput.value}`);

                // If check-out is before check-in, assume it's the next day
                if (checkOut < checkIn) {
                    checkOut.setDate(checkOut.getDate() + 1);
                }

                const diffMs = checkOut - checkIn;
                const diffMinutes = Math.floor(diffMs / (1000 * 60));

                workoutDurationInput.value = diffMinutes;
            }
        }

        checkInInput.addEventListener('change', calculateWorkoutDuration);
        checkOutInput.addEventListener('change', calculateWorkoutDuration);

        // Also calculate when page loads
        calculateWorkoutDuration();
    });
</script>
@endpush
