@extends('layouts.app')

@section('title', 'Farmers Markets & Interactive Map - MarketLink')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Farmers Markets</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Weekend Farmers Markets</h2>
            <p class="text-muted mb-0">Discover community markets, stall locations, and pickup points on the interactive map</p>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="card card-custom p-3 border-0 shadow-sm mb-4">
        <form action="{{ route('markets.index') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="city" class="form-select">
                    <option value="">-- All Cities --</option>
                    @foreach($cities as $c)
                        <option value="{{ $c }}" {{ $city === $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="day" class="form-select">
                    <option value="">-- All Operating Days --</option>
                    <option value="Saturday" {{ $day === 'Saturday' ? 'selected' : '' }}>Saturday</option>
                    <option value="Sunday" {{ $day === 'Sunday' ? 'selected' : '' }}>Sunday</option>
                    <option value="Friday" {{ $day === 'Friday' ? 'selected' : '' }}>Friday</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-market flex-grow-1"><i class="bi bi-filter me-1"></i> Apply Filter</button>
                <a href="{{ route('markets.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>

    <!-- Interactive Leaflet Map Container -->
    <div class="card card-custom p-2 border-0 shadow-sm mb-5">
        <div id="marketsMap" style="height: 420px; border-radius: 12px; z-index: 1;"></div>
    </div>

    <!-- Markets Grid -->
    <h4 class="fw-bold mb-3">All Active Markets ({{ $markets->count() }})</h4>
    <div class="row g-4">
        @forelse($markets as $market)
            <div class="col-md-6 col-lg-4">
                <div class="card card-custom h-100 border-0 shadow-sm">
                    <img src="{{ $market->image_url }}" class="card-img-top" style="height: 180px; object-fit: cover; border-top-left-radius: 14px; border-top-right-radius: 14px;" alt="{{ $market->name }}">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-success-subtle text-success">{{ $market->city }}</span>
                            <span class="badge bg-secondary-subtle text-secondary">{{ $market->farmerProfiles->count() }} Stalls</span>
                        </div>
                        <h5 class="fw-bold text-dark-emphasis mb-2">{{ $market->name }}</h5>
                        <p class="text-muted small mb-3 flex-grow-1">{{ $market->description }}</p>
                        
                        <div class="small text-muted mb-2">
                            <i class="fi fi-rr-marker text-danger me-1"></i> {{ $market->address }}
                        </div>
                        <div class="small text-muted mb-3">
                            <i class="fi fi-rr-calendar text-success me-1"></i> {{ $market->operating_days }} ({{ $market->opening_time }} - {{ $market->closing_time }})
                        </div>

                        <div class="d-flex gap-2 pt-2 border-top mt-auto">
                            <a href="{{ route('markets.show', $market->id) }}" class="btn btn-market btn-sm flex-grow-1">View Stalls & Produce</a>
                            <button class="btn btn-outline-success btn-sm" onclick="focusMarket({{ $market->latitude }}, {{ $market->longitude }}, '{{ addslashes($market->name) }}')">
                                <i class="fi fi-rr-map-pin"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fi fi-rr-marker text-muted fs-1"></i>
                <h5 class="fw-bold mt-2">No markets found</h5>
                <p class="text-muted">Try clearing your search filters to view all weekend farmers markets.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
    let map;
    let markers = [];

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Leaflet Map centered on Pakistan coordinates
        map = L.map('marketsMap').setView([24.8607, 67.0011], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const marketData = [
            @foreach($markets as $m)
                @if($m->latitude && $m->longitude)
                {
                    id: {{ $m->id }},
                    name: "{{ addslashes($m->name) }}",
                    city: "{{ addslashes($m->city) }}",
                    address: "{{ addslashes($m->address) }}",
                    days: "{{ addslashes($m->operating_days) }}",
                    timing: "{{ $m->opening_time }} - {{ $m->closing_time }}",
                    stalls: {{ $m->farmerProfiles->count() }},
                    lat: {{ $m->latitude }},
                    lng: {{ $m->longitude }},
                    url: "{{ route('markets.show', $m->id) }}"
                },
                @endif
            @endforeach
        ];

        const bounds = [];

        marketData.forEach(function(m) {
            const marker = L.marker([m.lat, m.lng]).addTo(map);
            const popupContent = `
                <div style="font-family: inherit; min-width: 200px;">
                    <h6 style="margin: 0 0 5px 0; font-weight: bold; color: #2d6a4f;">${m.name}</h6>
                    <p style="margin: 0 0 5px 0; font-size: 12px; color: #666;">${m.address}</p>
                    <p style="margin: 0 0 8px 0; font-size: 12px; color: #333;"><strong>${m.days}</strong> (${m.timing})</p>
                    <span style="display: inline-block; background: #d8f3dc; color: #1b4332; font-size: 11px; padding: 2px 6px; border-radius: 4px; margin-bottom: 8px;">${m.stalls} Stalls Active</span><br>
                    <a href="${m.url}" style="display: inline-block; background: #2d6a4f; color: #fff; text-decoration: none; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold;">View Stalls</a>
                </div>
            `;
            marker.bindPopup(popupContent);
            markers.push(marker);
            bounds.push([m.lat, m.lng]);
        });

        if (bounds.length > 0) {
            map.fitBounds(bounds, { padding: [40, 40] });
        }
    });

    function focusMarket(lat, lng, name) {
        if (map) {
            map.setView([lat, lng], 14);
            window.scrollTo({ top: document.getElementById('marketsMap').offsetTop - 100, behavior: 'smooth' });
        }
    }
</script>
@endsection
