@extends('layouts.app')

@section('title', 'My Profile Settings - MarketLink')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Account Profile</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center gap-3 mb-4 border-bottom pb-3">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $user->name }}</h4>
                        <span class="badge bg-secondary text-uppercase">{{ $user->role }}</span>
                        <small class="text-muted ms-2">Member since {{ $user->created_at->format('M Y') }}</small>
                    </div>
                </div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <h5 class="fw-bold text-success mb-3">Personal Details</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                            <small class="text-muted">Email address cannot be changed.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}" required>
                        </div>
                    </div>

                    <h5 class="fw-bold text-success mb-3 border-top pt-3">Security & Password (Optional)</h5>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Current Password</label>
                            <input type="password" name="current_password" class="form-control" placeholder="Required only if changing password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Min. 6 characters">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-market px-4">
                        <i class="bi bi-save me-1"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
