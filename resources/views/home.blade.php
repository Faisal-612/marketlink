@extends('layouts.app')

@section('title', 'MarketLink - Farmers Market Pre-Order Platform')

@section('content')
<!-- Clean Hero Section -->
<section class="container mb-5">
    <div class="card card-app p-5 border-0 shadow-sm">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 mb-3">
                    Fresh Weekly Harvests &bull; Pre-Order Online
                </span>
                <h1 class="fw-bold mb-3">
                    Farm Fresh Produce from <br><span class="text-success">Local Weekend Markets</span>
                </h1>
                <p class="text-secondary lead mb-4">
                    MarketLink connects you directly with local farmers. Browse live weekly harvest stock, select convenient pickup slots at weekend markets, and pay directly at the stall.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-primary-app">
                        <i class="fi fi-rr-apps me-1"></i> Browse Produce
                    </a>
                    <a href="{{ route('markets.index') }}" class="btn btn-outline-secondary">
                        <i class="fi fi-rr-marker me-1"></i> View Markets & Map
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block text-center">
                <img src="{{ asset('images/site/banner_101.png') }}" class="img-fluid rounded border shadow-sm" alt="Market Fresh Harvest" style="max-height: 280px; object-fit: cover; width: 100%;">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0 text-dark">Produce Categories</h4>
        <a href="{{ route('products.index') }}" class="text-success text-decoration-none small fw-semibold">View All</a>
    </div>
    <div class="row g-3">
        @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="text-decoration-none">
                    <div class="card card-app h-100 text-center p-3 text-dark">
                        <div class="text-success mb-2">
                            <i class="{{ $category->icon ?: 'fi fi-sr-carrot' }} fs-3"></i>
                        </div>
                        <h6 class="fw-bold mb-1">{{ $category->name }}</h6>
                        <small class="text-secondary">{{ $category->products_count }} items</small>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</section>

<!-- Featured Weekly Produce -->
<section class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Fresh Produce This Week</h4>
            <p class="text-secondary small mb-0">Harvested fresh for weekend market pickup</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-app">All Produce</a>
    </div>

    <div class="row g-3">
        @foreach($featuredProducts as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card card-app h-100 d-flex flex-column overflow-hidden">
                    <div class="position-relative">
                        <img src="{{ $product->image_url }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $product->name }}">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-dark">
                            {{ $product->category->name ?? 'Produce' }}
                        </span>
                        @auth
                            <button type="button" class="btn btn-sm btn-light rounded-circle position-absolute top-0 end-0 m-2 shadow-sm" onclick="toggleFavorite('product', {{ $product->id }}, this)">
                                <i class="{{ Auth::user()->favorites()->where('type', 'product')->where('target_id', $product->id)->exists() ? 'fi fi-sr-heart text-danger' : 'fi fi-rr-heart' }}"></i>
                            </button>
                        @endauth
                    </div>
                    <div class="card-body p-3 d-flex flex-column">
                        <small class="text-secondary mb-1">
                            <i class="fi fi-rr-shop me-1 text-success"></i>{{ $product->farmer->farmerProfile->stall_name ?? 'Local Farm' }}
                        </small>
                        <h6 class="fw-bold mb-1">
                            <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                        </h6>
                        <p class="text-secondary small mb-2 text-truncate">{{ $product->description }}</p>
                        
                        <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold text-success fs-5">Rs. {{ number_format($product->price, 0) }}</span>
                                <small class="text-secondary">/ {{ $product->unit }}</small>
                            </div>
                            <form action="{{ route('cart.add') }}" method="POST" onsubmit="return handleAddToCart(event, this);">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-sm btn-primary-app">
                                    <i class="fi fi-rr-plus"></i> Add
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Active Weekend Markets -->
<section class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold mb-0 text-dark">Weekend Farmers Markets</h4>
            <p class="text-secondary small mb-0">Browse market locations and stall schedules</p>
        </div>
        <a href="{{ route('markets.index') }}" class="btn btn-sm btn-outline-secondary"><i class="fi fi-rr-map me-1"></i> Interactive Map</a>
    </div>

    <div class="row g-3">
        @foreach($featuredMarkets as $market)
            <div class="col-md-6 col-lg-3">
                <div class="card card-app h-100 overflow-hidden">
                    <img src="{{ $market->image_url }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="{{ $market->name }}">
                    <div class="card-body p-3 d-flex flex-column">
                        <span class="badge bg-secondary-subtle text-secondary align-self-start mb-2">{{ $market->city }}</span>
                        <h6 class="fw-bold mb-1">
                            <a href="{{ route('markets.show', $market->id) }}" class="text-decoration-none text-dark">{{ $market->name }}</a>
                        </h6>
                        <small class="text-secondary d-block mb-1"><i class="fi fi-rr-calendar me-1 text-success"></i>{{ $market->operating_days }}</small>
                        <small class="text-secondary d-block mb-3"><i class="fi fi-rr-clock me-1"></i>{{ $market->opening_time }} - {{ $market->closing_time }}</small>
                        
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-auto">
                            <small class="text-secondary">{{ $market->farmer_profiles_count }} Stalls Active</small>
                            <a href="{{ route('markets.show', $market->id) }}" class="btn btn-sm btn-outline-app">View Stalls</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Farmer to Founder Feature Section -->
<section class="container mb-5">
    <div class="card card-app promo-card-cream border-0 overflow-hidden shadow-sm">
        <div class="row g-0 align-items-center">
            <div class="col-lg-6">
                <img src="{{ asset('images/site/banner_103.jpg') }}" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 320px; max-height: 420px;" alt="Farmer to Founder">
            </div>
            <div class="col-lg-6 p-4 p-md-5">
                <span class="badge bg-success-subtle text-success px-3 py-1 mb-3">Our Roots & Heritage</span>
                <h2 class="fw-bold mb-3" style="font-family: serif, system-ui;">Farmer to Founder</h2>
                <p class="text-secondary lead fs-6 mb-4">
                    MarketLink is proud to be founded from Agritech farming roots and sustainable leadership. We bridge the gap between conscientious local growers and urban families seeking pure, chemical-free food.
                </p>
                <a href="{{ route('about') }}" class="btn btn-primary-app px-4 py-2">
                    <i class="fi fi-rr-book-alt me-1"></i> Read More
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Promo Grid: Meet the Growers & Health & Vitality -->
<section class="container mb-5">
    <div class="row g-4">
        <!-- Meet the Growers Card -->
        <div class="col-md-6">
            <div class="card border-0 overflow-hidden shadow-sm h-100 promo-card-cream" style="border-radius: 14px;">
                <div class="row g-0 h-100 align-items-stretch">
                    <div class="col-sm-7 p-4 p-md-5 d-flex flex-column justify-content-center">
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 align-self-start px-2.5 py-1 mb-2 fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">ORGANIC • LOCAL • FRESH</span>
                        <h3 class="fw-bold mb-2 text-success" style="font-size: 1.45rem;">Meet the Growers</h3>
                        <p class="small mb-3 text-secondary" style="line-height: 1.55;">
                            Get to know where your food comes from by meeting the verified local farmers of our community.
                        </p>
                        <div>
                            <a href="{{ route('farmers.index') }}" class="btn btn-outline-success btn-sm fw-semibold px-3 py-2 rounded-2">
                                <i class="fi fi-rr-users me-1"></i> Real Farmers Stories
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-5 position-relative d-none d-sm-block">
                        <img src="{{ asset('images/site/banner_104.jpg') }}" class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover; object-position: center;" alt="Meet the Growers">
                    </div>
                </div>
            </div>
        </div>

        <!-- Health & Vitality Card -->
        <div class="col-md-6">
            <div class="card border-0 overflow-hidden shadow-sm h-100 promo-card-cream" style="border-radius: 14px;">
                <div class="row g-0 h-100 align-items-stretch">
                    <div class="col-sm-7 p-4 p-md-5 d-flex flex-column justify-content-center">
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 align-self-start px-2.5 py-1 mb-2 fw-bold" style="font-size: 0.72rem; letter-spacing: 0.5px;">WELLNESS &amp; HARVEST</span>
                        <h3 class="fw-bold mb-2 text-success" style="font-size: 1.45rem;">Health &amp; Vitality</h3>
                        <p class="small mb-3 text-secondary" style="line-height: 1.55;">
                            Fresh cold-pressed juices, pure raw mountain honey, and artisan preserves packed with natural nutrition.
                        </p>
                        <div>
                            <a href="{{ route('products.index') }}" class="btn btn-primary-app btn-sm fw-semibold px-3 py-2 rounded-2">
                                <i class="fi fi-rr-box-alt me-1"></i> Explore Produce &amp; Pantry
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-5 position-relative d-none d-sm-block">
                        <img src="{{ asset('images/site/banner_105.jpg') }}" class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover; object-position: center;" alt="Health & Vitality">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="container mb-5">
    <div class="card card-app p-4">
        <h4 class="fw-bold text-center mb-4 text-dark">How MarketLink Works</h4>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="p-2">
                    <div class="bg-light text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 fw-bold border" style="width: 48px; height: 48px; font-size: 20px;">
                        1
                    </div>
                    <h6 class="fw-bold">Browse & Add to Cart</h6>
                    <p class="small text-secondary">Browse weekly harvest stock from local farmers in your city and add items to your cart.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-2">
                    <div class="bg-light text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 fw-bold border" style="width: 48px; height: 48px; font-size: 20px;">
                        2
                    </div>
                    <h6 class="fw-bold">Select Pickup Date & Time</h6>
                    <p class="small text-secondary">Choose the market day and convenient time slot to collect your order at the stall.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-2">
                    <div class="bg-light text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 fw-bold border" style="width: 48px; height: 48px; font-size: 20px;">
                        3
                    </div>
                    <h6 class="fw-bold">Pickup & Pay at Market</h6>
                    <p class="small text-secondary">Visit the farmer stall, inspect your fresh produce bag, and settle payment in person.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Customer Reviews -->
@if($recentReviews->count() > 0)
<section class="container mb-4">
    <h4 class="fw-bold mb-3 text-dark">Customer Reviews</h4>
    <div class="row g-3">
        @foreach($recentReviews as $review)
            <div class="col-md-6 col-lg-3">
                <div class="card card-app h-100 p-3">
                    <div class="text-warning small mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $review->rating ? 'fi fi-sr-star text-warning' : 'fi fi-rr-star text-secondary' }}"></i>
                        @endfor
                    </div>
                    <p class="small text-secondary mb-3 fst-italic">"{{ $review->comment }}"</p>
                    <div class="mt-auto pt-2 border-top">
                        <span class="fw-bold small d-block text-dark">{{ $review->customer->name ?? 'Customer' }}</span>
                        <small class="text-success">{{ $review->farmer->farmerProfile->stall_name ?? 'Farm Stall' }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif
@endsection
