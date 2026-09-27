<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Farmer Portal') | MarketLink</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/site/logo.png') }}?v=3">

    <!-- Google Fonts: Plus Jakarta Sans & Inter (MonsterASP.NET Style) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Official Flaticon UIcons CDN (https://www.flaticon.com/uicons) -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <!-- FontAwesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --app-primary: #256052;
            --app-primary-hover: #1c4b40;
            --app-dark: #1e293b;
            --app-bg: #f8fafc;
            --app-card-bg: #ffffff;
            --app-sidebar-bg: #ffffff;
            --app-border: #e2e8f0;
            --app-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: var(--app-bg);
            color: var(--app-dark);
            min-height: 100vh;
            letter-spacing: -0.01em;
        }

        /* Master Boutique Button System */
        .btn {
            font-weight: 600;
            border-radius: 6px;
            padding: 0.5rem 1.25rem;
            letter-spacing: 0.2px;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            line-height: 1.4;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary-app, .btn-primary, .btn-success {
            background-color: var(--app-primary) !important;
            color: #ffffff !important;
            border: 1px solid var(--app-primary) !important;
            box-shadow: 0 2px 4px rgba(37, 96, 82, 0.18);
        }

        .btn-primary-app:hover, .btn-primary:hover, .btn-success:hover {
            background-color: var(--app-primary-hover) !important;
            border-color: var(--app-primary-hover) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(28, 75, 64, 0.25);
            transform: translateY(-1px);
        }

        .btn-outline-primary, .btn-outline-success {
            background: transparent !important;
            color: var(--app-primary) !important;
            border: 1.5px solid var(--app-primary) !important;
            font-weight: 600;
        }

        .btn-outline-primary:hover, .btn-outline-success:hover {
            background-color: var(--app-primary) !important;
            color: #ffffff !important;
            border-color: var(--app-primary) !important;
            box-shadow: 0 3px 8px rgba(37, 96, 82, 0.2);
            transform: translateY(-1px);
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Modern Light Sidebar for Farmer */
        .admin-sidebar {
            width: 260px;
            min-width: 260px;
            background-color: var(--app-sidebar-bg);
            border-right: 1px solid var(--app-border);
            display: flex;
            flex-direction: column;
            padding: 1.25rem 1rem;
            min-height: 100vh;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.25rem 0.5rem 1.25rem;
            text-decoration: none;
            border-bottom: 1px solid var(--app-border);
            margin-bottom: 1.25rem;
        }

        .brand-logo-badge {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: #dcfce7;
            color: var(--app-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .sidebar-section-title {
            font-size: 0.68rem;
            font-weight: 700;
            color: #9ca3af;
            letter-spacing: 0.08rem;
            text-transform: uppercase;
            padding: 0.5rem 0.65rem 0.35rem;
        }

        .sidebar-nav-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 0.75rem;
            color: #4b5563;
            font-size: 0.88rem;
            font-weight: 500;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 3px;
            transition: all 0.15s ease;
        }

        .sidebar-nav-item:hover {
            background-color: #f3f4f6;
            color: var(--app-dark);
        }

        .sidebar-nav-item.active {
            background-color: #f0fdf4;
            color: var(--app-primary);
            font-weight: 600;
            border: 1px solid #bbf7d0;
        }

        .rounded-circle, .avatar-circle, .monster-avatar-circle {
            flex-shrink: 0 !important;
            aspect-ratio: 1 / 1 !important;
        }

        .sidebar-user-card {
            margin-top: auto;
            background-color: #f9fafb;
            border: 1px solid var(--app-border);
            border-radius: 10px;
            padding: 0.65rem 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            min-width: 0;
        }

        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            min-width: 36px;
            min-height: 36px;
            max-width: 36px;
            max-height: 36px;
            border-radius: 50%;
            flex-shrink: 0;
            aspect-ratio: 1 / 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #16a34a;
            color: #ffffff;
            font-weight: 700;
        }

        /* Content Area */
        .admin-main-wrapper {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        /* Topbar Header */
        .admin-topbar {
            background-color: #ffffff;
            border-bottom: 1px solid var(--app-border);
            padding: 0.65rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1010;
        }

        .btn-monster-create {
            background-color: #16a34a;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.84rem;
            padding: 0.42rem 0.95rem;
            border-radius: 6px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-monster-create:hover {
            background-color: #15803d;
            color: #ffffff;
        }

        .topbar-pill-btn {
            background: transparent;
            border: none;
            color: #475569;
            font-size: 0.82rem;
            font-weight: 500;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: background 0.15s ease;
        }
        .topbar-pill-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .btn-monster-logout {
            border: 1.5px solid #cbd5e1;
            background: #ffffff;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.38rem 0.85rem;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-monster-logout:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a;
        }

        /* Header Hero */
        .page-header-card {
            background-color: #ffffff;
            border-radius: 12px;
            border: 1px solid var(--app-border);
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        /* Command Bar */
        .command-bar-card {
            background-color: #ffffff;
            border: 1px solid var(--app-border);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        .command-pill-btn {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            color: #374151;
            font-size: 0.82rem;
            font-weight: 500;
            padding: 0.4rem 0.85rem;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .command-pill-btn:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
            color: var(--app-primary);
        }

        /* Metric KPI Card */
        .kpi-card {
            background-color: #ffffff;
            border: 1px solid var(--app-border);
            border-radius: 12px;
            padding: 1.25rem 1.35rem;
            height: 100%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .kpi-icon-badge {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
        }

        /* Module Tool Card (Grid Items) */
        .module-tool-card {
            background-color: #ffffff;
            border: 1px solid var(--app-border);
            border-radius: 12px;
            padding: 1.25rem;
            height: 100%;
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }

        .module-tool-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.06);
            border-color: #86efac;
            color: inherit;
        }

        .module-icon-box {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            color: #ffffff;
        }

        /* Floating Toast Notifications */
        .app-toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }
        .app-toast {
            pointer-events: auto;
            min-width: 300px;
            max-width: 400px;
            background: #1e293b;
            color: #ffffff;
            border: 1px solid #334155;
            border-radius: 8px;
            padding: 12px 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideInToast 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes slideInToast {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
    @yield('styles')
</head>

<body>

    <div id="wrapper">

        <!-- Modern Left Sidebar -->
        <aside class="admin-sidebar d-none d-lg-flex">
            
            <!-- Brand -->
            <a href="{{ route('farmer.dashboard') }}" class="brand-box">
                <img src="{{ asset('images/site/logo.png') }}" alt="MarketLink" class="rounded-circle shadow-sm" style="width: 38px; height: 38px; object-fit: cover; border: 1.5px solid #256052;">
                <div>
                    <div class="fw-bold fs-6 text-dark lh-1">Farmer Portal</div>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-1 py-0 mt-1" style="font-size: 0.65rem;">STALL HUB</span>
                </div>
            </a>

            <!-- Sidebar Navigation Menu with Official Flaticon Icons -->
            <div class="flex-grow-1 overflow-y-auto">
                
                <a href="{{ route('farmer.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('farmer.dashboard') ? 'active' : '' }}">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fi fi-sr-dashboard text-success fs-6"></i>
                        <span>Overview</span>
                    </div>
                </a>

                <div class="sidebar-section-title mt-3">Harvest & Orders</div>

                <!-- Produce Inventory -->
                <a href="{{ route('farmer.products.index') }}" class="sidebar-nav-item {{ request()->routeIs('farmer.products.*') ? 'active' : '' }}">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fi fi-sr-carrot text-secondary fs-6"></i>
                        <span>Weekly Produce</span>
                    </div>
                </a>

                <!-- Incoming Pre-Orders -->
                <a href="{{ route('farmer.orders.index') }}" class="sidebar-nav-item {{ request()->routeIs('farmer.orders.*') ? 'active' : '' }}">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fi fi-sr-shopping-bag text-secondary fs-6"></i>
                        <span>Pre-Orders</span>
                    </div>
                </a>

                <!-- Customer Reviews -->
                <a href="{{ route('farmer.reviews.index') }}" class="sidebar-nav-item {{ request()->routeIs('farmer.reviews.*') ? 'active' : '' }}">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fi fi-sr-star text-secondary fs-6"></i>
                        <span>Reviews & Ratings</span>
                    </div>
                </a>

                <div class="sidebar-section-title mt-3">Stall Settings</div>

                <!-- Stall Profile -->
                <a href="{{ route('farmer.profile.edit') }}" class="sidebar-nav-item {{ request()->routeIs('farmer.profile.*') ? 'active' : '' }}">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fi fi-sr-settings text-secondary fs-6"></i>
                        <span>Stall Settings</span>
                    </div>
                </a>

            </div>

            <!-- Bottom User Card -->
            <div class="sidebar-user-card">
                <div class="d-flex align-items-center gap-2" style="min-width: 0; flex: 1;">
                    <div class="sidebar-user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="text-truncate" style="min-width: 0; flex: 1;">
                        <div class="fw-bold text-dark lh-1 text-truncate" style="font-size: 0.82rem;">{{ Auth::user()->name }}</div>
                        <small class="text-secondary text-truncate d-block mt-1" style="font-size: 0.7rem;">Farmer / Grower</small>
                    </div>
                </div>
                <span class="badge bg-success-subtle text-success border border-success-subtle px-1 py-0 flex-shrink-0" style="font-size: 0.68rem;">Verified</span>
            </div>

        </aside>

        <!-- Main Wrapper -->
        <div class="admin-main-wrapper">

            <!-- Topbar Navigation -->
            <header class="admin-topbar">
                <div class="d-flex align-items-center gap-2">
                    <div class="d-none d-md-flex align-items-center gap-2 small text-secondary">
                        <i class="fi fi-rr-shop text-muted"></i>
                        <span>/</span>
                        <span class="fw-semibold text-dark">{{ Auth::user()->farmerProfile->stall_name ?? 'Farm Stall Hub' }}</span>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <!-- + Create New Service Action Dropdown -->
                    <div class="dropdown">
                        <button class="btn-monster-create dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fi fi-rr-plus"></i> Add harvest item
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><a class="dropdown-item" href="{{ route('farmer.products.create') }}"><i class="fi fi-sr-carrot me-2 text-success"></i>New Produce Listing</a></li>
                            <li><a class="dropdown-item" href="{{ route('farmer.orders.index') }}"><i class="fi fi-sr-shopping-bag me-2 text-warning"></i>View Pre-Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('farmer.profile.edit') }}"><i class="fi fi-sr-settings me-2 text-secondary"></i>Edit Stall Profile</a></li>
                        </ul>
                    </div>

                    @php
                        $farmerPendingOrders = \App\Models\Order::where('farmer_id', Auth::id())->where('order_status', 'placed')->count();
                        $farmerTotalReviews = \App\Models\Review::where('farmer_id', Auth::id())->count();
                    @endphp

                    <!-- Tasks Pill -->
                    <a href="{{ route('farmer.orders.index') }}" class="topbar-pill-btn d-none d-lg-inline-flex text-decoration-none" title="Pending Pre-Orders to Fulfill">
                        <i class="fi fi-rr-list-check text-muted"></i> Tasks <span class="badge {{ $farmerPendingOrders > 0 ? 'bg-warning text-dark' : 'bg-secondary-subtle text-secondary' }} ms-1">{{ $farmerPendingOrders }}</span>
                    </a>

                    <!-- Messages Pill -->
                    <a href="{{ route('farmer.reviews.index') }}" class="topbar-pill-btn position-relative d-none d-sm-inline-flex text-decoration-none" title="Customer Reviews & Ratings">
                        <i class="fi fi-rr-envelope text-muted"></i> Reviews <span class="badge {{ $farmerTotalReviews > 0 ? 'bg-success text-white' : 'bg-secondary-subtle text-secondary' }} ms-1">{{ $farmerTotalReviews }}</span>
                    </a>

                    <!-- User Account Info Pill -->
                    <div class="d-none d-md-flex align-items-center gap-2 px-2 py-1 bg-light rounded-2 border">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 26px; height: 26px; font-size: 0.75rem;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="lh-1 text-start" style="font-size: 0.78rem;">
                            <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                            <small class="text-muted" style="font-size: 0.68rem;">{{ Auth::user()->email }}</small>
                        </div>
                    </div>

                    <!-- Log Out Button -->
                    <form action="{{ route('logout') }}" method="POST" class="d-inline mb-0">
                        @csrf
                        <button type="submit" class="btn-monster-logout">
                            <i class="fi fi-rr-sign-out-alt text-secondary"></i>
                            <span class="d-none d-sm-inline">Log out</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-3 p-md-4">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-top py-3 px-4 mt-auto text-secondary small text-center">
                &copy; {{ date('Y') }} MarketLink Farmer Stall Portal. All systems operational.
            </footer>

        </div>

    </div>

    <!-- Floating Toast Notifications -->
    <div class="app-toast-container">
        @if(session('success'))
            <div class="app-toast" id="toastSuccess">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-success"><i class="fi fi-sr-check fs-5"></i></span>
                    <span class="small">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white small ms-3" onclick="dismissToast('toastSuccess')"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="app-toast" id="toastError">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-danger"><i class="fi fi-sr-cross-circle fs-5"></i></span>
                    <span class="small">{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white small ms-3" onclick="dismissToast('toastError')"></button>
            </div>
        @endif
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function dismissToast(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.opacity = '0';
                el.style.transform = 'translateX(100%)';
                setTimeout(() => el.remove(), 300);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            ['toastSuccess', 'toastError'].forEach(id => {
                const el = document.getElementById(id);
                if (el) setTimeout(() => dismissToast(id), 4500);
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
