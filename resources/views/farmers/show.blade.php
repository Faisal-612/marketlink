@extends('layouts.app')

@section('title', $farmerProfile->stall_name . ' - Weekly Stock & Profile')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('farmers.index') }}" class="text-success text-decoration-none">Farmers</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $farmerProfile->stall_name }}</li>
        </ol>
    </nav>

    <!-- Stall Profile Banner -->
    <div class="card card-custom border-0 shadow-sm overflow-hidden mb-4">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{ $farmerProfile->banner_image_url }}" class="img-fluid h-100 w-100" style="object-fit: cover; min-height: 230px;" alt="{{ $farmerProfile->stall_name }}">
            </div>
            <div class="col-md-8 p-4 d-flex flex-column justify-content-center">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <span class="badge bg-success-subtle text-success mb-2">{{ $farmerProfile->market->city ?? 'Local Area' }}</span>
                        <h2 class="fw-bold mb-1">{{ $farmerProfile->stall_name }}</h2>
                        <p class="text-muted small mb-2"><i class="fi fi-rr-user me-1"></i>Grower: <strong>{{ $farmerProfile->user->name }}</strong></p>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-warning text-dark fs-6 px-3 py-2"><i class="fi fi-sr-star me-1"></i>{{ $farmerProfile->averageRating() }} / 5.0</span>
                        <small class="text-muted d-block mt-1">{{ $farmerProfile->reviews->count() }} Reviews</small>
                    </div>
                </div>

                <p class="text-muted mb-3">{{ $farmerProfile->bio }}</p>

                <div class="row g-2 small text-muted bg-light p-3 rounded-3">
                    <div class="col-sm-6"><i class="fi fi-rr-marker text-danger me-1"></i><strong>Market & Stall:</strong> {{ $farmerProfile->market->name ?? 'Farmers Market' }} ({{ $farmerProfile->stall_number ?: 'Assigned Stall' }})</div>
                    <div class="col-sm-6"><i class="fi fi-rr-calendar-check text-success me-1"></i><strong>Operating Days:</strong> {{ $farmerProfile->operating_days }}</div>
                    <div class="col-sm-6"><i class="fi fi-rr-clock text-warning me-1"></i><strong>Pickup Hours:</strong> {{ $farmerProfile->pickup_time_start }} - {{ $farmerProfile->pickup_time_end }}</div>
                    <div class="col-sm-6"><i class="fi fi-rr-hourglass-end text-info me-1"></i><strong>Pre-Order Cutoff:</strong> {{ $farmerProfile->order_cutoff_hours }} hrs before market</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Weekly Produce -->
    <h4 class="fw-bold mb-3"><i class="fi fi-rr-box text-success me-2"></i>Weekly Produce Available for Pre-Order ({{ $products->count() }})</h4>
    <div class="row g-4 mb-5">
        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card card-custom h-100 shadow-sm border-0 d-flex flex-column">
                    <div class="position-relative">
                        <img src="{{ $product->image_url }}" class="card-img-top" style="height: 180px; object-fit: cover; border-top-left-radius: 14px; border-top-right-radius: 14px;" alt="{{ $product->name }}">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-success">{{ $product->category->name ?? 'Fresh' }}</span>
                    </div>
                    <div class="card-body d-flex flex-column p-3">
                        <h6 class="fw-bold mb-1"><a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark-emphasis">{{ $product->name }}</a></h6>
                        <p class="text-muted small mb-2 text-truncate">{{ $product->description }}</p>
                        
                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fs-5 fw-bold text-success">Rs. {{ number_format($product->price, 0) }}</span>
                                <small class="text-muted">/ {{ $product->unit }}</small>
                            </div>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-sm btn-market" title="Add to Basket">
                                    <i class="fi fi-rr-plus"></i> Add
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-4">
                <p class="text-muted">This farmer has not listed products for this week yet.</p>
            </div>
        @endforelse
    </div>

    <!-- Customer Reviews Section -->
    <h4 class="fw-bold mb-3"><i class="fi fi-rr-comment-heart text-danger me-2"></i>Shopper Reviews & Stall Ratings</h4>
    <div class="row g-4">
        @forelse($farmerProfile->reviews as $review)
            <div class="col-md-6">
                <div class="card card-custom p-3 border-0 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold">{{ $review->customer->name ?? 'Shopper' }}</span>
                        <div class="text-warning small">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fi fi-sr-star text-warning' : 'fi fi-rr-star text-secondary' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-muted small mb-2">"{{ $review->comment }}"</p>
                    <small class="text-muted d-block mb-2">{{ $review->created_at->diffForHumans() }}</small>

                    @if($review->farmer_reply)
                        <div class="bg-light p-2 rounded-3 border-start border-success border-3 small mt-2">
                            <strong><i class="fi fi-rr-share text-success"></i> Farmer Response:</strong>
                            <p class="mb-0 text-muted">{{ $review->farmer_reply }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">No reviews posted for this farmer stall yet.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
