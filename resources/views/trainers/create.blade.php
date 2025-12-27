@extends('layouts.app')

@section('title', 'Add New Trainer')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user-plus me-2"></i>Add New Trainer</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('trainers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Trainers
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>Trainer Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('trainers.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Personal Information</h6>

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                           id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror"
                                          id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3">Professional Information</h6>

                            <div class="mb-3">
                                <label for="specialization" class="form-label">Specialization <span class="text-danger">*</span></label>
                                <select class="form-select @error('specialization') is-invalid @enderror" id="specialization" name="specialization" required>
                                    <option value="">Select Specialization</option>
                                    <option value="Personal Training" {{ old('specialization') == 'Personal Training' ? 'selected' : '' }}>Personal Training</option>
                                    <option value="Yoga" {{ old('specialization') == 'Yoga' ? 'selected' : '' }}>Yoga</option>
                                    <option value="Pilates" {{ old('specialization') == 'Pilates' ? 'selected' : '' }}>Pilates</option>
                                    <option value="CrossFit" {{ old('specialization') == 'CrossFit' ? 'selected' : '' }}>CrossFit</option>
                                    <option value="Weight Loss" {{ old('specialization') == 'Weight Loss' ? 'selected' : '' }}>Weight Loss</option>
                                    <option value="Body Building" {{ old('specialization') == 'Body Building' ? 'selected' : '' }}>Body Building</option>
                                    <option value="Rehabilitation" {{ old('specialization') == 'Rehabilitation' ? 'selected' : '' }}>Rehabilitation</option>
                                </select>
                                @error('specialization')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="experience_years" class="form-label">Experience (Years) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('experience_years') is-invalid @enderror"
                                       id="experience_years" name="experience_years" value="{{ old('experience_years') }}"
                                       min="0" max="50" required>
                                @error('experience_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="hourly_rate" class="form-label">Hourly Rate ($) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('hourly_rate') is-invalid @enderror"
                                       id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate') }}"
                                       min="0" required>
                                @error('hourly_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="certifications" class="form-label">Certifications</label>
                                <textarea class="form-control @error('certifications') is-invalid @enderror"
                                          id="certifications" name="certifications" rows="3"
                                          placeholder="List certifications (one per line)">{{ old('certifications') }}</textarea>
                                @error('certifications')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Enter each certification on a new line.</div>
                            </div>

                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio/Description</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror"
                                          id="bio" name="bio" rows="3"
                                          placeholder="Brief description about the trainer...">{{ old('bio') }}</textarea>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_available" name="is_available"
                                       value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_available">Available for new clients</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="reset" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-undo me-1"></i>Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Create Trainer
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
