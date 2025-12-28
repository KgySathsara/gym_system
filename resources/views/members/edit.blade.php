@extends('layouts.app')

@section('title', 'Edit Member')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-user-edit me-2"></i>Edit Member
    </h1>
    <a href="{{ route('members.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>Back to Members
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-user-circle me-2"></i>Edit Member Information
                </h5>
            </div>

            <div class="card-body">
                <form action="{{ route('members.update', $member->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- LEFT COLUMN -->
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Personal Information</h6>

                            <!-- PROFILE PHOTO -->
                            <div class="mb-4">
                                <label class="form-label">Profile Photo</label>

                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $member->user->profile_image
                                        ? asset('storage/profiles/' . $member->user->profile_image)
                                        : asset('assets/images/default-avatar.png') }}"
                                         class="rounded-circle border"
                                         width="90"
                                         height="90"
                                         style="object-fit: cover;">

                                    <input type="file"
                                           name="profile_image"
                                           class="form-control @error('profile_image') is-invalid @enderror"
                                           accept="image/*">
                                </div>

                                @error('profile_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <small class="text-muted">JPG, PNG (Max 2MB)</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text"
                                       name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $member->user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email"
                                       name="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $member->user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text"
                                           name="phone"
                                           class="form-control"
                                           value="{{ old('phone', $member->user->phone) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date"
                                           name="date_of_birth"
                                           class="form-control"
                                           value="{{ old('date_of_birth', optional($member->user->date_of_birth)->format('Y-m-d')) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address"
                                          class="form-control"
                                          rows="3">{{ old('address', $member->user->address) }}</textarea>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Membership Information</h6>

                            <div class="mb-3">
                                <label class="form-label">Plan *</label>
                                <select name="plan_id" class="form-select">
                                    @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}"
                                            {{ old('plan_id', $member->plan_id) == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Trainer</label>
                                <select name="trainer_id" class="form-select">
                                    <option value="">No Trainer</option>
                                    @foreach($trainers as $trainer)
                                        <option value="{{ $trainer->id }}"
                                            {{ old('trainer_id', $member->trainer_id) == $trainer->id ? 'selected' : '' }}>
                                            {{ $trainer->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Join Date *</label>
                                    <input type="date"
                                           name="join_date"
                                           class="form-control"
                                           value="{{ old('join_date', $member->join_date->format('Y-m-d')) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expiry Date *</label>
                                    <input type="date"
                                           name="expiry_date"
                                           class="form-control"
                                           value="{{ old('expiry_date', $member->expiry_date->format('Y-m-d')) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status *</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ $member->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $member->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="suspended" {{ $member->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Height (cm)</label>
                                    <input type="number"
                                           name="height"
                                           class="form-control"
                                           value="{{ old('height', $member->height) }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Weight (kg)</label>
                                    <input type="number"
                                           name="weight"
                                           class="form-control"
                                           value="{{ old('weight', $member->weight) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HEALTH -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Health & Fitness</h6>

                            <div class="mb-3">
                                <label class="form-label">Medical Conditions</label>
                                <textarea name="medical_conditions"
                                          class="form-control"
                                          rows="3">{{ old('medical_conditions', $member->medical_conditions) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Fitness Goals</label>
                                <textarea name="fitness_goals"
                                          class="form-control"
                                          rows="3">{{ old('fitness_goals', $member->fitness_goals) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div class="text-end mt-4">
                        <a href="{{ route('members.index') }}" class="btn btn-secondary me-2">
                            Cancel
                        </a>
                        <button class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Update Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
