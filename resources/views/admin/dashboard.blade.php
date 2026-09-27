@extends('layouts.admin')

@section('title', 'Admin Dashboard')
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
        background: #0284c7;
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
        color: #0d9488;
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
        background-color: #0d9488;
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
        background-color: #0f766e;
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

<!-- 1. MonsterASP.NET User Overview & Top Status Tiles -->
<div class="monster-header-row">
    
    <!-- Profile ID Card -->
    <div class="monster-profile-card">
        <div class="monster-avatar-circle">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
        </div>
        <div>
            <div class="d-flex align-items-center gap-2">
                <h5 class="fw-bold mb-0 text-dark">{{ Auth::user()->name }}</h5>
                <span class="badge bg-secondary-subtle text-secondary fw-bold" style="font-size: 0.7rem;">SUPERADMIN</span>
            </div>
            <div class="small text-muted mt-1">{{ Auth::user()->email }}</div>
            <div class="small text-secondary mt-1 d-flex flex-wrap align-items-center gap-2">
                <span><i class="fi fi-rr-phone-call small"></i> {{ Auth::user()->phone ?: '+923001234567' }}</span>
                <span class="badge bg-success-subtle text-success py-0 px-1"><i class="fi fi-sr-check" style="font-size: 0.6rem;"></i> Verified</span>
            </div>
            <div class="small text-muted mt-1" style="font-size: 0.78rem;">
                Admin ID: <strong>#ML-{{ str_pad(Auth::id(), 4, '0', STR_PAD_LEFT) }}</strong> &bull; 🇵🇰 Pakistan &bull; <strong>PKR</strong>
            </div>
        </div>
    </div>

    <!-- Status Tiles -->
    <div class="monster-status-tiles">
        
        <!-- Active Stalls Tile -->
        <a href="{{ route('admin.farmers.index') }}" class="monster-status-tile success-tile">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fi fi-sr-check-circle text-success fs-5"></i>
                    <div>
                        <strong class="d-block text-dark small">Farmers & Stalls</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">{{ $totalFarmers }} registered</span>
                    </div>
                </div>
            </div>
            <i class="fi fi-rr-angle-small-right text-muted fs-4"></i>
        </a>

        <!-- Markets Tile -->
        <a href="{{ route('admin.markets.index') }}" class="monster-status-tile success-tile">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fi fi-sr-check-circle text-success fs-5"></i>
                    <div>
                        <strong class="d-block text-dark small">Active Markets</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">{{ $totalMarkets }} cities active</span>
                    </div>
                </div>
            </div>
            <i class="fi fi-rr-angle-small-right text-muted fs-4"></i>
        </a>

        <!-- System AI Support Tile -->
        <div class="monster-status-tile success-tile">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fi fi-sr-check-circle text-success fs-5"></i>
                    <div>
                        <strong class="d-block text-dark small">Platform AI</strong>
                        <span class="text-muted" style="font-size: 0.78rem;">Chatbot 100% Online</span>
                    </div>
                </div>
            </div>
            <i class="fi fi-rr-angle-small-right text-muted fs-4"></i>
        </div>

        <!-- Pending Notices Tile -->
        <a href="{{ route('admin.farmers.index', ['status' => 'pending']) }}" class="monster-status-tile alert-tile">
            <div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fi fi-sr-exclamation text-warning fs-5"></i>
                    <div>
                        <strong class="d-block text-dark small">Pending Review</strong>
                        <span class="text-warning fw-semibold" style="font-size: 0.78rem;">{{ $pendingFarmers }} approvals</span>
                    </div>
                </div>
            </div>
            <i class="fi fi-rr-angle-small-right text-muted fs-4"></i>
        </a>

    </div>
</div>

<!-- 2. "Needs your attention" Monster Alert Banner -->
@if($pendingFarmers > 0)
    <div class="monster-alert-banner">
        <div class="d-flex align-items-center gap-2">
            <i class="fi fi-sr-info text-warning fs-5"></i>
            <div>
                <strong class="text-dark small d-block">Needs your attention</strong>
                <span class="text-secondary small">You have <strong>{{ $pendingFarmers }} pending farmer stall registration{{ $pendingFarmers > 1 ? 's' : '' }}</strong> awaiting verification from administration.</span>
            </div>
        </div>
        <a href="{{ route('admin.farmers.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-warning text-dark fw-semibold px-3">
            Review Stalls
        </a>
    </div>
@else
    <div class="monster-alert-banner" style="background: #f0fdf4; border-color: #dcfce7;">
        <div class="d-flex align-items-center gap-2">
            <i class="fi fi-sr-check-circle text-success fs-5"></i>
            <div>
                <strong class="text-dark small d-block">All systems operational</strong>
                <span class="text-secondary small">All farmer stalls, product inventories, and pre-orders are running smoothly across all markets.</span>
            </div>
        </div>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-outline-success fw-semibold px-3">
            Broadcast Notice
        </a>
    </div>
@endif

<!-- 3. YOUR PLATFORM SERVICES & MODULES -->
<div class="section-header-monster">
    <h6>YOUR PLATFORM SERVICES</h6>
    <span class="text-muted small" style="font-size: 0.75rem;">{{ $totalMarkets }} markets in 3 major cities</span>
</div>

<div class="row g-3 mb-4">
    
    <!-- Farmers Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="monster-metric-card">
            <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="metric-icon-box" style="background: #ecfdf5; color: #059669;">
                        <i class="fi fi-sr-shop"></i>
                    </div>
                    <div class="metric-big-number">{{ $totalFarmers }}</div>
                </div>
                <h6 class="fw-bold text-dark mb-1">Farmer Stalls</h6>
                <p class="text-muted small mb-0" style="font-size: 0.78rem;">
                    {{ $totalFarmers - $pendingFarmers }} verified &bull; {{ $pendingFarmers }} pending
                </p>
            </div>
            <div>
                <div class="metric-progress-subtext">
                    <span>{{ $totalFarmers - $pendingFarmers }} of {{ $totalFarmers }} active</span>
                    <span>100% capacity</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-1">
                    <a href="{{ route('admin.farmers.index') }}" class="small text-decoration-none fw-semibold text-success">Manage stalls</a>
                    <a href="{{ route('admin.farmers.index', ['status' => 'pending']) }}" class="btn-monster-cyan">
                        <i class="fi fi-rr-eye"></i> View
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Markets Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="monster-metric-card">
            <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="metric-icon-box" style="background: #eff6ff; color: #2563eb;">
                        <i class="fi fi-sr-marker"></i>
                    </div>
                    <div class="metric-big-number">{{ $totalMarkets }}</div>
                </div>
                <h6 class="fw-bold text-dark mb-1">Farmers Markets</h6>
                <p class="text-muted small mb-0" style="font-size: 0.78rem;">
                    Karachi, Lahore & Islamabad
                </p>
            </div>
            <div>
                <div class="metric-progress-subtext">
                    <span>GPS Map coordinates linked</span>
                    <span>Active</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-1">
                    <a href="{{ route('admin.markets.index') }}" class="small text-decoration-none fw-semibold text-primary">Manage markets</a>
                    <a href="{{ route('admin.markets.create') }}" class="btn-monster-cyan" style="background-color: #2563eb;">
                        <i class="fi fi-rr-plus"></i> Create
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Products & Stock Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="monster-metric-card">
            <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="metric-icon-box" style="background: #fefce8; color: #ca8a04;">
                        <i class="fi fi-sr-carrot"></i>
                    </div>
                    <div class="metric-big-number">{{ $totalProducts }}</div>
                </div>
                <h6 class="fw-bold text-dark mb-1">Produce Listings</h6>
                <p class="text-muted small mb-0" style="font-size: 0.78rem;">
                    Organic vegetables, fruits & herbs
                </p>
            </div>
            <div>
                <div class="metric-progress-subtext">
                    <span>Across {{ $totalCategories }} categories</span>
                    <span>Live</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-1">
                    <a href="{{ route('admin.categories.index') }}" class="small text-decoration-none fw-semibold text-warning text-dark">Categories</a>
                    <a href="{{ route('admin.categories.index') }}" class="btn-monster-cyan" style="background-color: #d97706;">
                        <i class="fi fi-rr-apps"></i> Catalog
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pre-Orders & GMV Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="monster-metric-card">
            <div>
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="metric-icon-box" style="background: #fdf2f8; color: #db2777;">
                        <i class="fi fi-sr-shopping-bag"></i>
                    </div>
                    <div class="metric-big-number">{{ $totalOrders }}</div>
                </div>
                <h6 class="fw-bold text-dark mb-1">Pre-Orders (GMV)</h6>
                <p class="text-muted small mb-0" style="font-size: 0.78rem;">
                    Rs. {{ number_format($totalRevenue, 0) }} total volume
                </p>
            </div>
            <div>
                <div class="metric-progress-subtext">
                    <span>{{ $pendingOrders }} pending pickups</span>
                    <span>98% filled</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 pt-1">
                    <a href="{{ route('admin.reports.index') }}" class="small text-decoration-none fw-semibold text-danger">Sales reports</a>
                    <a href="{{ route('admin.reports.index') }}" class="btn-monster-cyan" style="background-color: #db2777;">
                        <i class="fi fi-rr-chart-pie"></i> Reports
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
        <a href="{{ route('admin.markets.create') }}" class="monster-action-block bg-action-teal">
            <i class="fi fi-rr-plus fs-4"></i>
            <div>
                <strong class="d-block" style="font-size: 0.85rem;">New market</strong>
                <small class="opacity-90" style="font-size: 0.72rem;">Weekend locations in minutes</small>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.categories.index') }}" class="monster-action-block bg-action-teal">
            <i class="fi fi-rr-plus fs-4"></i>
            <div>
                <strong class="d-block" style="font-size: 0.85rem;">New category</strong>
                <small class="opacity-90" style="font-size: 0.72rem;">Produce & crop taxonomy</small>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.announcements.index') }}" class="monster-action-block bg-action-teal">
            <i class="fi fi-rr-plus fs-4"></i>
            <div>
                <strong class="d-block" style="font-size: 0.85rem;">Broadcast alert</strong>
                <small class="opacity-90" style="font-size: 0.72rem;">Notifications for farmers & buyers</small>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.reports.index') }}" class="monster-action-block bg-action-blue">
            <i class="fi fi-rr-shopping-cart fs-4"></i>
            <div>
                <strong class="d-block" style="font-size: 0.85rem;">GMV Analytics</strong>
                <small class="opacity-90" style="font-size: 0.72rem;">More reports, sales and summaries</small>
            </div>
        </a>
    </div>
</div>

<!-- 5. Recent Pre-Orders Table & Top Active Stalls -->
<div class="row g-4">
    <!-- Recent Platform Orders -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-dark">Recent Pre-Orders Across Markets</h6>
                <a href="{{ route('admin.reports.index') }}" class="small text-success text-decoration-none fw-semibold">View all orders &rarr;</a>
            </div>
            
            <div class="table-responsive">
                <table class="table align-middle table-hover small">
                    <thead class="table-light">
                        <tr>
                            <th>Order Code</th>
                            <th>Customer</th>
                            <th>Stall / Market</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="fw-bold text-dark">#{{ $order->order_number }}</td>
                                <td>{{ $order->customer->name ?? 'Shopper' }}</td>
                                <td>
                                    <div>{{ $order->farmer->farmerProfile->stall_name ?? 'Local Farm' }}</div>
                                    <small class="text-muted">{{ $order->farmer->farmerProfile->market->name ?? 'Market' }}</small>
                                </td>
                                <td class="fw-bold text-success">Rs. {{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    @if($order->status === 'completed')
                                        <span class="badge bg-success-subtle text-success">Completed</span>
                                    @elseif($order->status === 'pending')
                                        <span class="badge bg-warning-subtle text-warning">Pending</span>
                                    @elseif($order->status === 'ready_for_pickup')
                                        <span class="badge bg-info-subtle text-info">Ready for Pickup</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No recent orders placed yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Active Markets Snapshot -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h6 class="fw-bold mb-3 text-dark">Active Weekend Markets</h6>
            <div class="d-flex flex-column gap-3">
                @foreach($markets as $m)
                    <div class="d-flex align-items-center justify-content-between p-2 rounded-3 border bg-light">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fi fi-sr-marker text-success fs-5"></i>
                            <div>
                                <strong class="d-block text-dark small">{{ $m->name }}</strong>
                                <small class="text-muted">{{ $m->city }} &bull; {{ $m->operating_days }}</small>
                            </div>
                        </div>
                        <span class="badge bg-success-subtle text-success">{{ $m->farmer_profiles_count }} Stalls</span>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('admin.markets.index') }}" class="btn btn-sm btn-outline-secondary w-100 mt-3">
                Manage All Markets
            </a>
        </div>
    </div>
</div>

<!-- MonsterASP.NET Style Floating Support Button -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
    <a href="{{ route('admin.announcements.index') }}" class="btn btn-white bg-white border shadow-sm rounded-pill px-3 py-2 d-flex align-items-center gap-2 text-dark text-decoration-none">
        <i class="fi fi-rr-comment-alt-dots text-primary fs-5"></i>
        <div class="text-start lh-1">
            <strong class="d-block" style="font-size: 0.8rem;">Open ticket</strong>
            <small class="text-muted" style="font-size: 0.68rem;">Ask our support team</small>
        </div>
    </a>
</div>

@endsection
