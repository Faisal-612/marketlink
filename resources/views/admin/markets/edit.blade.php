@extends('layouts.admin')

@section('title', 'Edit Farmers Market')
@section('page-title', 'Edit Farmers Market: ' . $market->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card card-stat border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-4">Update Market Configuration</h5>

            <form action="{{ route('admin.markets.update', $market->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Market Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $market->name) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control" value="{{ old('city', $market->city) }}" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Full Address <span class="text-danger">*</span></label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $market->address) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Operating Days <span class="text-danger">*</span></label>
                        <input type="text" name="operating_days" class="form-control" value="{{ old('operating_days', $market->operating_days) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Opening Time <span class="text-danger">*</span></label>
                        <input type="text" name="opening_time" class="form-control" value="{{ old('opening_time', $market->opening_time) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Closing Time <span class="text-danger">*</span></label>
                        <input type="text" name="closing_time" class="form-control" value="{{ old('closing_time', $market->closing_time) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Latitude</label>
                        <input type="number" step="0.00000001" name="latitude" class="form-control" value="{{ old('latitude', $market->latitude) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Longitude</label>
                        <input type="number" step="0.00000001" name="longitude" class="form-control" value="{{ old('longitude', $market->longitude) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Market Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ $market->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $market->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Market Image URL</label>
                        <input type="url" name="image" class="form-control" value="{{ old('image', $market->image) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $market->description) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="{{ route('admin.markets.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success px-4">Update Market</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
