@extends('layouts.app')

@section('title', 'Saved Favorites - MarketLink')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Saved Favorites</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-4"><i class="bi bi-heart-fill text-danger me-2"></i>My Saved Favorites</h2>

    @if($favorites->count() > 0)
        <div class="row g-4">
            @foreach($favorites as $fav)
                @if($fav->type === 'product' && $fav->product)
                    <div class="col-md-6 col-lg-3">
                        <div class="card card-custom h-100 p-3 border-0 shadow-sm d-flex flex-column">
                            <img src="{{ $fav->product->image ?: 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=500&auto=format&fit=crop&q=60' }}" class="card-img-top rounded mb-2" style="height: 150px; object-fit: cover;" alt="{{ $fav->product->name }}">
                            <h6 class="fw-bold mb-1"><a href="{{ route('products.show', $fav->product->id) }}" class="text-decoration-none text-dark-emphasis">{{ $fav->product->name }}</a></h6>
                            <small class="text-muted mb-2"><i class="bi bi-shop me-1 text-success"></i>{{ $fav->product->farmer->farmerProfile->stall_name ?? 'Farm Stall' }}</small>
                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-success">Rs. {{ number_format($fav->product->price, 0) }} / {{ $fav->product->unit }}</span>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $fav->product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-sm btn-market"><i class="bi bi-plus"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @elseif($fav->type === 'farmer' && $fav->farmer && $fav->farmer->farmerProfile)
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-custom h-100 p-4 border-0 shadow-sm d-flex flex-column">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 20px;">
                                    <i class="bi bi-shop"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0"><a href="{{ route('farmers.show', $fav->farmer->farmerProfile->id) }}" class="text-decoration-none text-dark-emphasis">{{ $fav->farmer->farmerProfile->stall_name }}</a></h5>
                                    <small class="text-muted"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $fav->farmer->farmerProfile->market->name ?? 'Farmers Market' }}</small>
                                </div>
                            </div>
                            <p class="text-muted small mb-3 flex-grow-1">{{ Str::limit($fav->farmer->farmerProfile->bio, 90) }}</p>
                            <a href="{{ route('farmers.show', $fav->farmer->farmerProfile->id) }}" class="btn btn-market btn-sm mt-auto">Visit Stall</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="card card-custom p-5 border-0 shadow-sm text-center">
            <i class="bi bi-heart text-muted" style="font-size: 4rem;"></i>
            <h4 class="fw-bold mt-3">No Saved Favorites Yet</h4>
            <p class="text-muted mb-4">Click the heart icon on any fresh produce item or farmer stall to bookmark it for quick weekly access.</p>
            <div>
                <a href="{{ route('products.index') }}" class="btn btn-market px-4">Explore Produce</a>
            </div>
        </div>
    @endif
</div>
@endsection
