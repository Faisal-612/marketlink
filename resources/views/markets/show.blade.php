@extends('layouts.app')

@section('title', $market->name . ' - Farmers & Stalls')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('markets.index') }}" class="text-success text-decoration-none">Markets</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $market->name }}</li>
        </ol>
    </nav>

    <!-- Market Banner Header -->
    <div class="card card-custom border-0 shadow-sm overflow-hidden mb-4">
        <div class="row g-0">
            <div class="col-md-5">
                <img src="{{ $market->image_url }}" class="img-fluid h-100 w-100" style="object-fit: cover; min-height: 250px;" alt="{{ $market->name }}">
            </div>
            <div class="col-md-7 p-4 d-flex flex-column justify-content-center">
                <div class="d-flex gap-2 mb-2">
                    <span class="badge bg-success">{{ $market->city }}</span>
                    <span class="badge bg-warning text-dark">{{ $market->operating_days }}</span>
                </div>
                <h2 class="fw-bold mb-2">{{ $market->name }}</h2>
                <p class="text-muted mb-3">{{ $market->description }}</p>
                <div class="row g-2 small text-muted">
                    <div class="col-sm-6"><i class="fi fi-rr-marker text-danger me-1"></i> <strong>Location:</strong> {{ $market->address }}</div>
                    <div class="col-sm-6"><i class="fi fi-rr-clock text-warning me-1"></i> <strong>Timings:</strong> {{ $market->opening_time }} - {{ $market->closing_time }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Farmers at this market -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Verified Farmers & Stalls at this Market ({{ $market->farmerProfiles->count() }})</h4>
    </div>

    <div class="row g-4">
        @forelse($market->farmerProfiles as $farmerProfile)
            <div class="col-md-6 col-lg-4">
                <div class="card card-custom h-100 p-4 border-0 shadow-sm d-flex flex-column">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 20px;">
                            <i class="fi fi-rr-shop"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0"><a href="{{ route('farmers.show', $farmerProfile->id) }}" class="text-decoration-none text-dark-emphasis">{{ $farmerProfile->stall_name }}</a></h5>
                            <small class="text-muted"><i class="fi fi-rr-map-pin text-danger me-1"></i>{{ $farmerProfile->stall_number ?: 'Stall Assigned' }}</small>
                        </div>
                    </div>

                    <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($farmerProfile->bio, 100) }}</p>

                    <!-- Produce Preview -->
                    @if($farmerProfile->products->count() > 0)
                        <div class="mb-3">
                            <small class="fw-semibold text-muted d-block mb-1">Available Produce:</small>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($farmerProfile->products as $p)
                                    <span class="badge bg-light text-dark border">{{ $p->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="pt-3 border-top mt-auto d-flex justify-content-between align-items-center">
                        <small class="text-muted"><i class="bi bi-clock me-1"></i>Pickup: {{ $farmerProfile->pickup_time_start }} - {{ $farmerProfile->pickup_time_end }}</small>
                        <a href="{{ route('farmers.show', $farmerProfile->id) }}" class="btn btn-sm btn-market">Visit Stall</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-4">
                <p class="text-muted">No farmers registered for this market yet.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
