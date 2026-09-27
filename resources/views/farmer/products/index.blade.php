@extends('layouts.farmer')

@section('title', 'Manage Weekly Produce Stock')
@section('page-title', 'Weekly Produce Inventory & Stock')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <p class="text-muted mb-0">Update your available stock for the upcoming weekend market</p>
    </div>
    <div class="d-flex gap-2">
        <form action="{{ route('farmer.products.apply_weekly_template') }}" method="POST" onsubmit="return confirm('Apply weekly template to replenish standard inventory levels?');">
            @csrf
            <button type="submit" class="btn btn-outline-success">
                <i class="bi bi-arrow-repeat me-1"></i> Apply Weekly Template
            </button>
        </form>
        <a href="{{ route('farmer.products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Add New Item
        </a>
    </div>
</div>

<!-- Filters Bar -->
<div class="card card-stat border-0 shadow-sm p-3 mb-4">
    <form action="{{ route('farmer.products.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search my produce..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-select form-select-sm">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-success flex-grow-1">Filter</button>
            <a href="{{ route('farmer.products.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="card card-stat border-0 shadow-sm overflow-hidden p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Price / Unit</th>
                    <th>Available Stock</th>
                    <th>Weekly Template</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $product->image_url }}" class="rounded" style="width: 48px; height: 48px; object-fit: cover;" alt="{{ $product->name }}">
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $product->name }}</h6>
                                    <small class="text-muted">{{ Str::limit($product->description, 45) }}</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $product->category->name ?? 'General' }}</span></td>
                        <td><strong>Rs. {{ number_format($product->price, 0) }}</strong> / {{ $product->unit }}</td>
                        <td>
                            <span class="badge {{ $product->stock_quantity > 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fs-6">
                                {{ $product->stock_quantity }} {{ $product->unit }}
                            </span>
                        </td>
                        <td>
                            @if($product->is_weekly_template)
                                <span class="badge bg-info-subtle text-info border"><i class="fi fi-rr-check me-1"></i>Template</span>
                            @else
                                <span class="text-muted small">No</span>
                            @endif
                        </td>
                        <td>
                            @if($product->is_sold_out || $product->stock_quantity == 0)
                                <span class="badge bg-danger">Sold Out</span>
                            @else
                                <span class="badge bg-success">In Stock</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <form action="{{ route('farmer.products.toggle_sold_out', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $product->is_sold_out ? 'btn-outline-success' : 'btn-outline-warning' }}" title="Toggle Status">
                                    {{ $product->is_sold_out ? 'Mark In Stock' : 'Mark Sold Out' }}
                                </button>
                            </form>
                            <a href="{{ route('farmer.products.edit', $product->id) }}" class="btn btn-sm btn-outline-app" title="Edit">
                                <i class="fi fi-rr-edit"></i> Edit
                            </a>
                            <form action="{{ route('farmer.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this produce item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fi fi-rr-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No produce items listed yet. Click "Add New Item" to list your harvest.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection
