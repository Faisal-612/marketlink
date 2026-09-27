@extends('layouts.app')

@section('title', $product->name . ' - Farm Fresh Details')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-success text-decoration-none">Produce</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- Product Main Detail Card -->
    <div class="card card-custom border-0 shadow-sm overflow-hidden p-4 mb-5">
        <div class="row g-5">
            <div class="col-md-5">
                <img src="{{ $product->image_url }}" class="img-fluid rounded-4 w-100 shadow-sm" style="object-fit: cover; max-height: 400px;" alt="{{ $product->name }}">
            </div>
            <div class="col-md-7 d-flex flex-column justify-content-center">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-success-subtle text-success">{{ $product->category->name ?? 'Fresh Produce' }}</span>
                    @auth
                        <button class="btn btn-outline-danger btn-sm rounded-circle" onclick="toggleFavorite('product', {{ $product->id }}, this)">
                            <i class="{{ Auth::user()->favorites()->where('type', 'product')->where('target_id', $product->id)->exists() ? 'fi fi-sr-heart text-danger' : 'fi fi-rr-heart' }}"></i>
                        </button>
                    @endauth
                </div>

                <h2 class="fw-bold mb-2">{{ $product->name }}</h2>
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-warning text-dark"><i class="fi fi-sr-star text-dark me-1"></i>{{ $product->averageRating() }} / 5.0</span>
                    <small class="text-muted">({{ $product->reviews->count() }} customer ratings)</small>
                </div>

                <div class="mb-3">
                    <span class="display-6 fw-bold text-success">Rs. {{ number_format($product->price, 0) }}</span>
                    <span class="text-muted fs-5">/ {{ $product->unit }}</span>
                </div>

                <p class="text-muted mb-4">{{ $product->description }}</p>

                <!-- Farmer Stall Card Box -->
                <div class="bg-light p-3 rounded-3 border mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block">Grown & Harvested by:</small>
                            <h6 class="fw-bold mb-0"><i class="fi fi-rr-shop text-success me-1"></i>{{ $product->farmer->farmerProfile->stall_name ?? 'Local Farm' }}</h6>
                            <small class="text-muted"><i class="fi fi-rr-marker text-success me-1"></i>{{ $product->farmer->farmerProfile->market->name ?? 'Farmers Market' }}</small>
                        </div>
                        <a href="{{ route('farmers.show', $product->farmer->farmerProfile->id ?? 1) }}" class="btn btn-sm btn-outline-success">View Stall Profile</a>
                    </div>
                </div>

                <!-- Pre-Order Form -->
                <form action="{{ route('cart.add') }}" method="POST" onsubmit="return handleAddToCart(event, this);" class="d-flex gap-3 align-items-center">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div style="width: 120px;">
                        <input type="number" name="quantity" class="form-control form-control-lg" value="1" min="1" max="{{ max(1, $product->stock_quantity) }}">
                    </div>
                    <button type="submit" class="btn btn-market btn-lg flex-grow-1" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                        <i class="fi fi-rr-shopping-cart me-2"></i> {{ $product->stock_quantity > 0 ? 'Add to Pre-Order Basket' : 'Currently Out of Stock' }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Related Produce -->
    @if($relatedProducts->count() > 0)
        <h4 class="fw-bold mb-3">Related Fresh Produce</h4>
        <div class="row g-4">
            @foreach($relatedProducts as $rel)
                <div class="col-6 col-md-3">
                    <div class="card card-custom h-100 p-3 border-0 shadow-sm">
                        <img src="{{ $rel->image_url }}" class="card-img-top rounded mb-2" style="height: 140px; object-fit: cover;" alt="{{ $rel->name }}">
                        <h6 class="fw-bold mb-1"><a href="{{ route('products.show', $rel->id) }}" class="text-decoration-none text-dark-emphasis">{{ $rel->name }}</a></h6>
                        <span class="text-success fw-bold">Rs. {{ number_format($rel->price, 0) }} / {{ $rel->unit }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
