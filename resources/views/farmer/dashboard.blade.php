@extends('layouts.farmer')

@section('title', 'Farmer Stall Dashboard')
@section('page-title', 'Dashboard')

@section('styles')
<style>
    .monster-header-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 16px;
        align-items: stretch;
    }
    .monster-profile-card {
        background: #ffffff;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 0.85rem 1.15rem;
        display: flex;
        align-items: center;
        gap: 14px;
        flex: 1 1 300px;
    }
    .monster-avatar-circle {
        width: 48px;
        height: 48px;
        min-width: 48px;
        min-height: 48px;
        aspect-ratio: 1 / 1;
        border-radius: 50%;
        background: #16a34a;
        color: #ffffff;
        font-size: 1.15rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .monster-status-tiles {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        flex: 2 1 480px;
    }
    .monster-status-tile {
        background: #ffffff;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 0.65rem 0.95rem;
        flex: 1 1 105px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        color: inherit;
        transition: all 0.15s ease;
    }
    .monster-status-tile:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 10px -2px rgba(0, 0, 0, 0.05);
        transform: translateY(-1px);
    }
    .monster-status-tile.alert-tile {
        border-left: 3.5px solid #f59e0b;
    }
    .monster-status-tile.success-tile {
        border-left: 3.5px solid #10b981;
    }

    /* Needs Your Attention Alert Banner */
    .monster-alert-banner {
        background: #fffbeb;
        border: 1px solid #fef3c7;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 18px;
    }

    .section-header-monster {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .section-header-monster h6 {
        font-size: 0.72rem;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 0.05rem;
        text-transform: uppercase;
        margin-bottom: 0;
    }

    /* MonsterASP.NET Metric Cards */
    .monster-metric-card {
        background: #ffffff;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 1rem 1.15rem;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.2s ease;
    }
    .monster-metric-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.05);
    }
    .metric-icon-box {
        width: 34px;
        height: 34px;
        border-radius: 6px;
        background: #f0fdf4;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    .metric-big-number {
        font-size: 1.85rem;
        font-weight: 700;
        color: #16a34a;
        line-height: 1;
    }
    .metric-progress-subtext {
        font-size: 0.72rem;
        color: #94a3b8;
        border-top: 1px solid #f1f5f9;
        padding-top: 6px;
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
    }
    .btn-monster-cyan {
        background-color: #16a34a;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        padding: 3px 10px;
        font-size: 0.76rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .btn-monster-cyan:hover {
        background-color: #15803d;
        color: #ffffff;
    }

    /* Monster Action Quick Launchers at bottom */
    .monster-action-block {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        color: #ffffff;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 64px;
        transition: all 0.15s ease;
    }
    .monster-action-block:hover {
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px -2px rgba(0,0,0,0.15);
    }
    .bg-action-teal { background: #00a896; }
    .bg-action-green { background: #16a34a; }
    .bg-action-blue { background: #0284c7; }
</style>
@endsection

@section('content')

<!-- Breadcrumb -->
<div class="d-flex align-items-center gap-2 mb-3 text-secondary small">
    <i class="fi fi-rr-home text-muted"></i>
    <span>/</span>
    <span class="fw-semibold text-dark">Dashboard</span>
</div>

<!-- 1. MonsterASP.NET Farmer Profile Card & Top Status Tiles -->
<div class="monster-header-row">
    
    <!-- Profile ID Card -->
    <div class="monster-profile-card">
        <div class="monster-avatar-circle">
            {{ strtoupper(substr($profile->stall_name ?? Auth::user()->name, 0, 2)) }}
        </div>
        <div>
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold mb-0 text-dark">{{ $profile->stall_name ?? Auth::user()->name }}</h5>
                <span class="badge bg-success-subtle text-success fw-bold" style="font-size: 0.7rem;">ACTIVE GROWER</span>
            </div>
            <div class="small text-muted mt-1">{{ Auth::user()->email }}</div>
            <div class="small text-secondary mt-1 d-flex flex-wrap align-items-center gap-2">
                <span><i class="fi fi-rr-phone-call small"></i> {{ Auth::user()->phone ?: '+923219876543' }}</span>
                <span class="badge bg-success-subtle text-success py-0 px-1"><i class="fi fi-sr-check" style="font-size: 0.6rem;"></i> Verified Stall</span>
            </div>
            <div class="small text-muted mt-1" style="font-size: 0.78rem;">
                Stall ID: <strong>#FARM-{{ str_pad(Auth::id(), 4, '0', STR_PAD_LEFT) }}</strong> &bull; 🇵🇰 {{ $profile->market->city ?? 'Pakistan' }} &bull; <strong>PKR</strong>
            </div>
        </div>
    </div>

    <!-- Status Tiles -->
    <div class="monster-status-tiles">
        
        <!-- Live Produce Items Tile -->
        <a href="{{ route('farmer.products.index') }}" class="monster-status-tile success-tile">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fi fi-sr-check-circle text-success fs-5"></i>
                    <div>
                        <strong class="d-block text-dark small">Produce Items</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">{{ $totalProducts }} listed in catalog</span>
                    </div>
                </div>
            </div>
            <i class="fi fi-rr-angle-small-right text-muted fs-4"></i>
        </a>

        <!-- Pending Pre-Orders Tile -->
        <a href="{{ route('farmer.orders.index', ['status' => 'pending']) }}" class="monster-status-tile {{ $pendingOrders > 0 ? 'alert-tile' : 'success-tile' }}">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <i class="{{ $pendingOrders > 0 ? 'fi fi-sr-exclamation text-warning' : 'fi fi-sr-check-circle text-success' }} fs-5"></i>
                    <div>
                        <strong class="d-block text-dark small">Pre-Orders</strong>
                        <span class="{{ $pendingOrders > 0 ? 'text-warning fw-bold' : 'text-muted' }}" style="font-size: 0.78rem;">{{ $pendingOrders }} pending pickup</span>
                    </div>
                </div>
            </div>
            <i class="fi fi-rr-angle-small-right text-muted fs-4"></i>
        </a>

        <!-- Assigned Market Location Tile -->
        <a href="{{ route('farmer.profile.edit') }}" class="monster-status-tile success-tile">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fi fi-sr-marker text-primary fs-5"></i>
                    <div>
                        <strong class="d-block text-dark small">Assigned Market</strong>
                        <span class="text-muted text-truncate d-block" style="font-size: 0.78rem; max-width: 120px;">{{ $profile->market->name ?? 'Farmers Market' }}</span>
                    </div>
                </div>
            </div>
            <i class="fi fi-rr-angle-small-right text-muted fs-4"></i>
        </a>

        <!-- Customer Rating Tile -->
        <a href="{{ route('farmer.reviews.index') }}" class="monster-status-tile success-tile">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fi fi-sr-star text-warning fs-5"></i>
                    <div>
                        <strong class="d-block text-dark small">Stall Rating</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">{{ number_format($averageRating, 1) }} ★ ({{ $totalReviews }} reviews)</span>
                    </div>
                </div>
            </div>
            <i class="fi fi-rr-angle-small-right text-muted fs-4"></i>
        </a>

    </div>
</div>

<!-- 2. "Needs your attention" Monster Alert Banner -->
@if($pendingOrders > 0)
    <div class="monster-alert-banner">
        <div class="d-flex align-items-center gap-2">
            <i class="fi fi-sr-info text-warning fs-5"></i>
            <div>
                <strong class="text-dark small d-block">Needs your attention</strong>
                <span class="text-secondary small">You have <strong>{{ $pendingOrders }} new pre-order{{ $pendingOrders > 1 ? 's' : '' }}</strong> awaiting preparation for weekend pickup.</span>
            </div>
        </div>
        <a href="{{ route('farmer.orders.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-warning text-dark fw-semibold px-3">
            Prepare Crates
        </a>
    </div>
@else
    <div class="monster-alert-banner" style="background: #f0fdf4; border-color: #dcfce7;">
        <div class="d-flex align-items-center gap-2">
            <i class="fi fi-sr-check-circle text-success fs-5"></i>
            <div>
                <strong class="text-dark small d-block">All orders up to date</strong>
                <span class="text-secondary small">No pending pre-orders right now. Keep your weekly stock and prices updated before market day.</span>
            </div>
        </div>
        <a href="{{ route('farmer.products.create') }}" class="btn btn-sm btn-outline-success fw-semibold px-3">
            + Add Fresh Crop
        </a>
    </div>
@endif

<!-- 3. YOUR STALL SERVICES & METRICS -->
<div class="section-header-monster">
    <h6>YOUR STALL SERVICES</h6>
    <span class="text-muted small" style="font-size: 0.75rem;">{{ $totalProducts }} items listed in {{ $profile->market->name ?? 'Market' }}</span>
</div>

<div class="row g-3 mb-4">
    
    <!-- Total Pre-Orders Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="monster-metric-card">
            <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="metric-icon-box" style="background: #eff6ff; color: #2563eb;">
                        <i class="fi fi-sr-shopping-bag"></i>
                    </div>
                    <div class="metric-big-number">{{ $totalOrders }}</div>
                </div>
                <h6 class="fw-bold text-dark mb-1">Pre-Orders</h6>
                <p class="text-muted small mb-0" style="font-size: 0.78rem;">
                    {{ $completedOrders }} completed &bull; {{ $pendingOrders }} pending
                </p>
            </div>
            <div>
                <div class="metric-progress-subtext">
                    <span>{{ $completedOrders }} of {{ $totalOrders }} fulfilled</span>
                    <span>95% rate</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-1">
                    <a href="{{ route('farmer.orders.index') }}" class="small text-decoration-none fw-semibold text-primary">Manage orders</a>
                    <a href="{{ route('farmer.orders.index') }}" class="btn-monster-cyan" style="background-color: #2563eb;">
                        <i class="fi fi-rr-eye"></i> View
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Produce Items Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="monster-metric-card">
            <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="metric-icon-box" style="background: #ecfdf5; color: #059669;">
                        <i class="fi fi-sr-carrot"></i>
                    </div>
                    <div class="metric-big-number">{{ $totalProducts }}</div>
                </div>
                <h6 class="fw-bold text-dark mb-1">Produce Items</h6>
                <p class="text-muted small mb-0" style="font-size: 0.78rem;">
                    Organic vegetables & fruits listed
                </p>
            </div>
            <div>
                <div class="metric-progress-subtext">
                    <span>Weekly stock live</span>
                    <span>Ready</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-1">
                    <a href="{{ route('farmer.products.index') }}" class="small text-decoration-none fw-semibold text-success">Manage catalog</a>
                    <a href="{{ route('farmer.products.create') }}" class="btn-monster-cyan">
                        <i class="fi fi-rr-plus"></i> Add
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stall Revenue Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="monster-metric-card">
            <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="metric-icon-box" style="background: #fdf2f8; color: #db2777;">
                        <i class="fi fi-sr-chart-histogram"></i>
                    </div>
                    <div class="metric-big-number" style="font-size: 1.6rem; padding-top: 6px;">Rs. {{ number_format($totalRevenue, 0) }}</div>
                </div>
                <h6 class="fw-bold text-dark mb-1">Estimated Sales</h6>
                <p class="text-muted small mb-0" style="font-size: 0.78rem;">
                    Paid in-person at pickup
                </p>
            </div>
            <div>
                <div class="metric-progress-subtext">
                    <span>Zero middleman commission</span>
                    <span>100% direct</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-1">
                    <a href="{{ route('farmer.orders.index') }}" class="small text-decoration-none fw-semibold text-danger">Sales log</a>
                    <a href="{{ route('farmer.orders.index') }}" class="btn-monster-cyan" style="background-color: #db2777;">
                        <i class="fi fi-rr-file-invoice"></i> Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Shopper Reviews Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="monster-metric-card">
            <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="metric-icon-box" style="background: #fefce8; color: #ca8a04;">
                        <i class="fi fi-sr-star"></i>
                    </div>
                    <div class="metric-big-number">{{ number_format($averageRating, 1) }}</div>
                </div>
                <h6 class="fw-bold text-dark mb-1">Customer Reviews</h6>
                <p class="text-muted small mb-0" style="font-size: 0.78rem;">
                    Based on {{ $totalReviews }} verified ratings
                </p>
            </div>
            <div>
                <div class="metric-progress-subtext">
                    <span>Verified market shoppers</span>
                    <span>Active</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-1">
                    <a href="{{ route('farmer.reviews.index') }}" class="small text-decoration-none fw-semibold text-warning text-dark">Read reviews</a>
                    <a href="{{ route('farmer.reviews.index') }}" class="btn-monster-cyan" style="background-color: #d97706;">
                        <i class="fi fi-rr-comment"></i> Reviews
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- 4. Monster Action Quick Launcher Bar -->
<div class="section-header-monster">
    <h6>QUICK ACTION LAUNCHERS</h6>
</div>

<div class="row g-2 mb-4">
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('farmer.products.create') }}" class="monster-action-block bg-action-teal">
            <i class="fi fi-rr-plus fs-4"></i>
            <div>
                <strong class="d-block" style="font-size: 0.85rem;">New produce</strong>
                <small class="opacity-90" style="font-size: 0.72rem;">List fresh crops in minutes</small>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <form action="{{ route('farmer.products.apply_weekly_template') }}" method="POST" class="m-0 p-0">
            @csrf
            <button type="submit" class="monster-action-block bg-action-green w-100 text-start border-0">
                <i class="fi fi-rr-refresh fs-4"></i>
                <div>
                    <strong class="d-block" style="font-size: 0.85rem;">Weekly template</strong>
                    <small class="opacity-90" style="font-size: 0.72rem;">Reset standard weekend stock</small>
                </div>
            </button>
        </form>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('farmer.profile.edit') }}" class="monster-action-block bg-action-green">
            <i class="fi fi-rr-clock fs-4"></i>
            <div>
                <strong class="d-block" style="font-size: 0.85rem;">Pickup window</strong>
                <small class="opacity-90" style="font-size: 0.72rem;">Set weekend collection hours</small>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('farmer.orders.index') }}" class="monster-action-block bg-action-blue">
            <i class="fi fi-rr-shopping-bag fs-4"></i>
            <div>
                <strong class="d-block" style="font-size: 0.85rem;">Pre-Order list</strong>
                <small class="opacity-90" style="font-size: 0.72rem;">Customer pickup orders & crates</small>
            </div>
        </a>
    </div>
</div>

<!-- 5. Recent Incoming Orders Table -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0 text-dark">Recent Incoming Pre-Orders</h6>
        <a href="{{ route('farmer.orders.index') }}" class="small text-success text-decoration-none fw-semibold">View all orders &rarr;</a>
    </div>
    
    <div class="table-responsive">
        <table class="table align-middle table-hover small">
            <thead class="table-light">
                <tr>
                    <th>Order Code</th>
                    <th>Customer Name</th>
                    <th>Items Reserved</th>
                    <th>Pickup Window</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td class="fw-bold text-dark">#{{ $order->order_number }}</td>
                        <td>
                            <div>{{ $order->customer->name ?? 'Shopper' }}</div>
                            <small class="text-muted">{{ $order->customer->phone ?? '' }}</small>
                        </td>
                        <td>{{ $order->items->count() }} items</td>
                        <td>
                            <div class="small fw-semibold">{{ $order->pickup_date ? \Carbon\Carbon::parse($order->pickup_date)->format('D, M d') : 'Weekend' }}</div>
                            <small class="text-muted">{{ $order->pickup_time_slot ?? '9 AM - 12 PM' }}</small>
                        </td>
                        <td class="fw-bold text-success">Rs. {{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="badge {{ $order->status_badge }}">{{ $order->status_label }}</span>
                        </td>
                        <td>
                            <a href="{{ route('farmer.orders.show', $order->id) }}" class="btn btn-sm btn-outline-secondary py-1 px-2">
                                Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No pre-orders placed yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MonsterASP.NET Style Floating Support Button -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
    <a href="{{ route('farmer.reviews.index') }}" class="btn btn-white bg-white border shadow-sm rounded-pill px-3 py-2 d-flex align-items-center gap-2 text-dark text-decoration-none">
        <i class="fi fi-rr-comment-alt-dots text-success fs-5"></i>
        <div class="text-start lh-1">
            <strong class="d-block" style="font-size: 0.8rem;">Open ticket</strong>
            <small class="text-muted" style="font-size: 0.68rem;">Ask our support team</small>
        </div>
    </a>
</div>

@endsection
