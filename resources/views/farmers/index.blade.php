@extends('layouts.app')

@section('title', 'Verified Farmers & Stalls - MarketLink')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Farmers Directory</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-shop text-success me-2"></i>Verified Local Farmers & Stalls</h2>
            <p class="text-muted mb-0">Directly connect with smallholder growers, view weekly harvest, and pre-order for market day pickup</p>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="card card-custom p-3 border-0 shadow-sm mb-4">
        <form action="{{ route('farmers.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search by farm stall or grower name..." value="{{ $search }}">
            </div>
            <div class="col-md-4">
                <select name="market_id" class="form-select">
                    <option value="">-- Filter by Market --</option>
                    @foreach($markets as $m)
                        <option value="{{ $m->id }}" {{ $marketId == $m->id ? 'selected' : '' }}>{{ $m->name }} ({{ $m->city }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-market flex-grow-1"><i class="bi bi-search me-1"></i> Search</button>
                <a href="{{ route('farmers.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>

    <!-- Farmers Cards Grid -->
    <div class="row g-4">
        @forelse($farmers as $farmer)
            <div class="col-md-6 col-lg-4">
                <div class="card card-custom h-100 border-0 shadow-sm d-flex flex-column overflow-hidden">
                    <img src="{{ $farmer->banner_image_url }}" class="card-img-top" style="height: 140px; object-fit: cover;" alt="{{ $farmer->stall_name }}">
                    
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="fw-bold mb-0"><a href="{{ route('farmers.show', $farmer->id) }}" class="text-decoration-none text-dark-emphasis">{{ $farmer->stall_name }}</a></h5>
                            <span class="badge bg-warning text-dark"><i class="fi fi-sr-star text-dark me-1"></i>{{ $farmer->averageRating() }}</span>
                        </div>
                        <small class="text-muted d-block mb-2">
                            <i class="fi fi-rr-marker text-danger me-1"></i>{{ $farmer->market->name ?? 'Independent Stall' }} ({{ $farmer->stall_number ?: 'Main Bay' }})
                        </small>
                        <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($farmer->bio, 110) }}</p>

                        <div class="bg-light p-2 rounded small mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span><i class="fi fi-rr-calendar me-1 text-success"></i>Market Days:</span>
                                <strong>{{ $farmer->operating_days ?? 'Sat, Sun' }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="fi fi-rr-clock me-1 text-warning"></i>Pickup Hours:</span>
                                <strong>{{ $farmer->pickup_time_start }} - {{ $farmer->pickup_time_end }}</strong>
                            </div>
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top mt-auto">
                            <a href="{{ route('farmers.show', $farmer->id) }}" class="btn btn-market btn-sm flex-grow-1">View Stall & Produce</a>
                            @auth
                                <button class="btn btn-sm btn-outline-danger" onclick="toggleFavorite('farmer', {{ $farmer->user_id }}, this)">
                                    <i class="{{ Auth::user()->favorites()->where('type', 'farmer')->where('target_id', $farmer->user_id)->exists() ? 'fi fi-sr-heart text-danger' : 'fi fi-rr-heart' }}"></i>
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fi fi-rr-shop text-muted fs-1"></i>
                <h5 class="fw-bold mt-2">No farmers found</h5>
                <p class="text-muted">Try adjusting your search criteria.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $farmers->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
