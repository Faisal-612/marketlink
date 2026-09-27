@extends('layouts.app')

@section('title', 'Fresh Produce Catalog - MarketLink')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Produce Catalog</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card card-custom p-4 border-0 shadow-sm sticky-top" style="top: 90px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-funnel-fill text-success me-1"></i> Filter Produce</h5>
                    <a href="{{ route('products.index') }}" class="small text-muted text-decoration-none">Clear</a>
                </div>

                <form action="{{ route('products.index') }}" method="GET">
                    <!-- Search Field -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Search Keywords</label>
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="e.g. Apples, Tomatoes..." value="{{ $search }}">
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Category</label>
                        <select name="category" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }} ({{ $cat->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Market Filter -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Farmers Market</label>
                        <select name="market" class="form-select form-select-sm">
                            <option value="">All Markets</option>
                            @foreach($markets as $m)
                                <option value="{{ $m->id }}" {{ $marketId == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Price Range (PKR)</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min" value="{{ $minPrice }}">
                            </div>
                            <div class="col-6">
                                <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max" value="{{ $maxPrice }}">
                            </div>
                        </div>
                    </div>

                    <!-- Sort Filter -->
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Sort By</label>
                        <select name="sort" class="form-select form-select-sm">
                            <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Latest Harvest</option>
                            <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Alphabetical (A-Z)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-market btn-sm w-100 py-2">
                        <i class="bi bi-filter me-1"></i> Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Available Fresh Produce ({{ $products->total() }})</h4>
                <span class="text-muted small">Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} items</span>
            </div>

            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card card-custom h-100 shadow-sm border-0 d-flex flex-column">
                            <div class="position-relative">
                                <img src="{{ $product->image_url }}" class="card-img-top" style="height: 180px; object-fit: cover; border-top-left-radius: 14px; border-top-right-radius: 14px;" alt="{{ $product->name }}">
                                <span class="position-absolute top-0 start-0 m-2 badge bg-success">
                                    {{ $product->category->name ?? 'Produce' }}
                                </span>
                                @auth
                                    <button class="btn btn-sm btn-light rounded-circle position-absolute top-0 end-0 m-2 shadow-sm" onclick="toggleFavorite('product', {{ $product->id }}, this)">
                                        <i class="{{ Auth::user()->favorites()->where('type', 'product')->where('target_id', $product->id)->exists() ? 'fi fi-sr-heart text-danger' : 'fi fi-rr-heart' }}"></i>
                                    </button>
                                @endauth
                            </div>
                            <div class="card-body d-flex flex-column p-3">
                                <small class="text-muted d-block mb-1">
                                    <i class="fi fi-rr-shop text-success me-1"></i>{{ $product->farmer->farmerProfile->stall_name ?? 'Local Farm' }}
                                </small>
                                <h6 class="fw-bold mb-1"><a href="{{ route('products.show', $product->id) }}" class="text-decoration-none text-dark-emphasis">{{ $product->name }}</a></h6>
                                <p class="text-muted small mb-2 text-truncate">{{ $product->description }}</p>
                                
                                <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fs-5 fw-bold text-success">Rs. {{ number_format($product->price, 0) }}</span>
                                        <small class="text-muted">/ {{ $product->unit }}</small>
                                    </div>
                                    <form action="{{ route('cart.add') }}" method="POST" onsubmit="return handleAddToCart(event, this);">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-sm btn-market" title="Add to Pre-Order Basket">
                                            <i class="fi fi-rr-plus"></i> Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fi fi-rr-shopping-bag text-muted fs-1"></i>
                        <h5 class="fw-bold mt-2">No produce found</h5>
                        <p class="text-muted">Try clearing your search filters to view all fresh harvest items.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
