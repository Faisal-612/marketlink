@extends('layouts.admin')

@section('title', 'Add Weekend Farmers Market')
@section('page-title', 'Create New Farmers Market Location')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-stat border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-4">Market Details & Geolocation</h5>

            <form action="{{ route('admin.markets.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Market Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Clifton Beachside Farmers Market" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', 'Karachi') }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Full Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="Street, block, landmark" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Operating Days <span class="text-danger">*</span></label>
                        <input type="text" name="operating_days" class="form-control" value="{{ old('operating_days', 'Saturday, Sunday') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Opening Time <span class="text-danger">*</span></label>
                        <input type="text" name="opening_time" class="form-control" value="{{ old('opening_time', '08:00 AM') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Closing Time <span class="text-danger">*</span></label>
                        <input type="text" name="closing_time" class="form-control" value="{{ old('closing_time', '02:00 PM') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Latitude Coordinate <span class="text-danger">*</span></label>
                        <input type="number" step="0.00000001" name="latitude" class="form-control" value="{{ old('latitude', '24.8138') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Longitude Coordinate <span class="text-danger">*</span></label>
                        <input type="number" step="0.00000001" name="longitude" class="form-control" value="{{ old('longitude', '67.0300') }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Market Image URL</label>
                        <input type="url" name="image" class="form-control" value="{{ old('image') }}" placeholder="https://images.unsplash.com/...">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="{{ route('admin.markets.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success px-4">Create Farmers Market</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
