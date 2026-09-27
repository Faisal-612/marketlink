@extends('layouts.admin')

@section('title', 'Manage Weekend Markets')
@section('page-title', 'Farmers Markets & Geolocation Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Add, edit, or configure weekend farmers market locations and timings</p>
    <a href="{{ route('admin.markets.create') }}" class="btn btn-success">
        <i class="bi bi-plus-lg me-1"></i> Add New Farmers Market
    </a>
</div>

<div class="row g-4">
    @foreach($markets as $market)
        <div class="col-md-6 col-lg-4">
            <div class="card card-stat border-0 shadow-sm h-100 p-0 overflow-hidden d-flex flex-column">
                <img src="{{ $market->image_url }}" style="height: 160px; width: 100%; object-fit: cover;" alt="{{ $market->name }}">
                <div class="p-4 d-flex flex-column flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0 text-dark">{{ $market->name }}</h5>
                        <span class="badge {{ $market->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($market->status) }}</span>
                    </div>
                    <small class="text-muted d-block mb-2"><i class="fi fi-rr-marker text-danger me-1"></i>{{ $market->city }} - {{ $market->address }}</small>
                    <small class="text-muted d-block mb-3"><i class="fi fi-rr-calendar text-success me-1"></i>{{ $market->operating_days }} ({{ $market->opening_time }} - {{ $market->closing_time }})</small>
                    
                    <div class="small bg-light p-2 rounded mb-3">
                        <i class="fi fi-rr-crosshairs text-primary me-1"></i> Lat: <code>{{ $market->latitude }}</code> | Lng: <code>{{ $market->longitude }}</code>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-auto">
                        <span class="badge bg-success-subtle text-success">{{ $market->farmer_profiles_count }} Stalls Active</span>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.markets.edit', $market->id) }}" class="btn btn-sm btn-outline-app">
                                <i class="fi fi-rr-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.markets.destroy', $market->id) }}" method="POST" onsubmit="return confirm('Delete this market location?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Market">
                                    <i class="fi fi-rr-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
