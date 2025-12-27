@extends('layouts.app')

@section('title', 'Edit Member')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user-edit me-2"></i>Edit Member</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('members.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Members
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Edit Member Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('members.update', $member->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Personal Information</h6>

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $member->user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $member->user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone', $member->user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                           id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $member->user->date_of_birth ? $member->user->date_of_birth->format('Y-m-d') : '') }}">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address" name="address" rows="3">{{ old('address', $member->user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Membership Information</h6>

                            <div class="mb-3">
                                <label for="plan_id" class="form-label">Membership Plan <span class="text-danger">*</span></label>
                                <select class="form-select @error('plan_id') is-invalid @enderror" id="plan_id" name="plan_id" required>
                                    <option value="">Select a Plan</option>
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" {{ old('plan_id', $member->plan_id) == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }} - ${{ number_format($plan->price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('plan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="trainer_id" class="form-label">Assign Trainer</label>
                                <select class="form-select @error('trainer_id') is-invalid @enderror" id="trainer_id" name="trainer_id">
                                    <option value="">No Trainer</option>
                                    @foreach($trainers as $trainer)
                                        <option value="{{ $trainer->id }}" {{ old('trainer_id', $member->trainer_id) == $trainer->id ? 'selected' : '' }}>
                                            {{ $trainer->user->name }} - {{ $trainer->specialization }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('trainer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="join_date" class="form-label">Join Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('join_date') is-invalid @enderror"
                                           id="join_date" name="join_date" value="{{ old('join_date', $member->join_date->format('Y-m-d')) }}" required>
                                    @error('join_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="expiry_date" class="form-label">Expiry Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('expiry_date') is-invalid @enderror"
                                           id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $member->expiry_date->format('Y-m-d')) }}" required>
                                    @error('expiry_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="suspended" {{ old('status', $member->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="height" class="form-label">Height (cm)</label>
                                    <input type="number" step="0.1" class="form-control @error('height') is-invalid @enderror"
                                           id="height" name="height" value="{{ old('height', $member->height) }}">
                                    @error('height')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="weight" class="form-label">Weight (kg)</label>
                                    <input type="number" step="0.1" class="form-control @error('weight') is-invalid @enderror"
                                           id="weight" name="weight" value="{{ old('weight', $member->weight) }}">
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Health & Fitness</h6>

                            <div class="mb-3">
                                <label for="medical_conditions" class="form-label">Medical Conditions</label>
                                <textarea class="form-control @error('medical_conditions') is-invalid @enderror"
                                          id="medical_conditions" name="medical_conditions" rows="3">{{ old('medical_conditions', $member->medical_conditions) }}</textarea>
                                @error('medical_conditions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="fitness_goals" class="form-label">Fitness Goals</label>
                                <textarea class="form-control @error('fitness_goals') is-invalid @enderror"
                                          id="fitness_goals" name="fitness_goals" rows="3">{{ old('fitness_goals', $member->fitness_goals) }}</textarea>
                                @error('fitness_goals')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('members.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i>Update Member
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
