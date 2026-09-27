@extends('layouts.farmer')

@section('title', 'Stall Profile & Schedule')
@section('page-title', 'Configure Stall Profile & Pickup Schedule')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card card-stat border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-4">Farm Stall Details & Pickup Hours</h5>

            <form action="{{ route('farmer.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Stall / Farm Business Name <span class="text-danger">*</span></label>
                        <input type="text" name="stall_name" class="form-control" value="{{ old('stall_name', $profile->stall_name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Associated Farmers Market</label>
                        <select name="market_id" class="form-select">
                            <option value="">-- Independent Stall / No Market Assigned --</option>
                            @foreach($markets as $m)
                                <option value="{{ $m->id }}" {{ old('market_id', $profile->market_id) == $m->id ? 'selected' : '' }}>
                                    {{ $m->name }} ({{ $m->city }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Stall Number / Bay Pin</label>
                        <input type="text" name="stall_number" class="form-control" value="{{ old('stall_number', $profile->stall_number) }}" placeholder="e.g. Stall #A-12">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Operating Days <span class="text-danger">*</span></label>
                        <input type="text" name="operating_days" class="form-control" value="{{ old('operating_days', $profile->operating_days ?? 'Saturday, Sunday') }}" placeholder="e.g. Saturday, Sunday" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pickup Time Start <span class="text-danger">*</span></label>
                        <input type="time" name="pickup_time_start" class="form-control" value="{{ old('pickup_time_start', $profile->pickup_time_start ?? '08:00') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pickup Time End <span class="text-danger">*</span></label>
                        <input type="time" name="pickup_time_end" class="form-control" value="{{ old('pickup_time_end', $profile->pickup_time_end ?? '14:00') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Pre-Order Cutoff (Hours before market) <span class="text-danger">*</span></label>
                        <input type="number" name="order_cutoff_hours" class="form-control" value="{{ old('order_cutoff_hours', $profile->order_cutoff_hours ?? 3) }}" min="1" max="48" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Stall Latitude (For Map Pin)</label>
                        <input type="text" name="latitude" class="form-control" value="{{ old('latitude', $profile->latitude) }}" placeholder="e.g. 24.8142">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Stall Longitude (For Map Pin)</label>
                        <input type="text" name="longitude" class="form-control" value="{{ old('longitude', $profile->longitude) }}" placeholder="e.g. 67.0305">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Stall Banner Image URL</label>
                        <input type="url" name="banner_image" class="form-control" value="{{ old('banner_image', $profile->banner_image) }}" placeholder="https://images.unsplash.com/...">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">About Farm & Specialty Produce</label>
                        <textarea name="bio" class="form-control" rows="4" placeholder="Tell community shoppers about your organic farming methods...">{{ old('bio', $profile->bio) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-success px-4 fw-semibold">
                        <i class="bi bi-save me-1"></i> Save Stall Configuration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
