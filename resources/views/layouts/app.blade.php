<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MarketLink - Farmers Market Pre-Order')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/site/logo.png') }}?v=3">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Flaticon UIcons CDN (flaticon.com) -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-solid-rounded/css/uicons-solid-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.6.0/uicons-bold-rounded/css/uicons-bold-rounded.css">
    <!-- FontAwesome 6 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Leaflet CSS for Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <style>
        /* Boutique Artisan Farm Theme: Deep Pine Green (#256052) & Dark Slate (#1e293b) */
        :root {
            --app-primary: #256052;
            --app-primary-hover: #1c4b40;
            --app-dark: #1e293b;
            --app-muted: #64748b;
            --app-bg: #f8fafc;
            --app-card-border: #e2e8f0;
        }

        body {
            background-color: var(--app-bg);
            color: var(--app-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            letter-spacing: -0.01em;
        }

        [data-bs-theme="dark"] body {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        /* Accessibility Font Sizing */
        body.font-sm { font-size: 14px; }
        body.font-md { font-size: 16px; }
        body.font-lg { font-size: 18px; }

        /* Navbar */
        .navbar-main {
            background-color: #ffffff;
            border-bottom: 1px solid var(--app-card-border);
        }
        [data-bs-theme="dark"] .navbar-main {
            background-color: #1e293b;
            border-bottom: 1px solid #334155;
        }

        .rounded-circle, .avatar-circle, .monster-avatar-circle {
            flex-shrink: 0 !important;
            aspect-ratio: 1 / 1 !important;
        }

        .brand-title {
            font-weight: 700;
            color: var(--app-primary) !important;
            font-size: 1.35rem;
            text-decoration: none;
        }

        /* Nav Links */
        .navbar-nav .nav-link {
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.5rem 0.75rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Master Boutique Farmette Button System */
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
            text-decoration: none;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary-app, .btn-market, .btn-primary, .btn-success {
            background-color: var(--app-primary) !important;
            color: #ffffff !important;
            border: 1px solid var(--app-primary) !important;
            box-shadow: 0 2px 4px rgba(37, 96, 82, 0.18);
        }

        .btn-primary-app:hover, .btn-market:hover, .btn-primary:hover, .btn-success:hover {
            background-color: var(--app-primary-hover) !important;
            border-color: var(--app-primary-hover) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 10px rgba(28, 75, 64, 0.25);
            transform: translateY(-1px);
        }

        .btn-outline-app, .btn-outline-primary, .btn-outline-success {
            background: transparent !important;
            color: var(--app-primary) !important;
            border: 1.5px solid var(--app-primary) !important;
            font-weight: 600;
        }

        .btn-outline-app:hover, .btn-outline-primary:hover, .btn-outline-success:hover {
            background-color: var(--app-primary) !important;
            color: #ffffff !important;
            border-color: var(--app-primary) !important;
            box-shadow: 0 3px 8px rgba(37, 96, 82, 0.2);
            transform: translateY(-1px);
        }

        .btn-sm {
            padding: 0.35rem 0.85rem !important;
            font-size: 0.875rem !important;
        }

        .btn-lg {
            padding: 0.7rem 1.6rem !important;
            font-size: 1.05rem !important;
        }

        /* Professional Navbar Action Button System */
        .nav-actions-group {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .nav-icon-action {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            text-decoration: none;
            position: relative;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .nav-icon-action:hover {
            background: #f8fafc;
            border-color: var(--app-primary);
            color: var(--app-primary);
            transform: translateY(-1px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
        }

        [data-bs-theme="dark"] .nav-icon-action {
            background: #1e293b;
            border-color: #475569;
            color: #cbd5e1;
        }

        [data-bs-theme="dark"] .nav-icon-action:hover {
            background: #334155;
            border-color: #86efac;
            color: #86efac;
        }

        .cart-badge-dot {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--app-primary);
            color: #ffffff;
            font-size: 0.68rem;
            font-weight: 700;
            min-width: 19px;
            height: 19px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
            padding: 0 4px;
            line-height: 1;
        }

        [data-bs-theme="dark"] .cart-badge-dot {
            border-color: #1e293b;
        }

        /* Compact Sleek User Pill */
        .nav-user-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 38px;
            padding: 0 14px 0 5px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            white-space: nowrap;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .nav-user-pill:hover, .nav-user-pill:focus {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: var(--app-primary);
        }
        [data-bs-theme="dark"] .nav-user-pill {
            background: #1e293b;
            border-color: #334155;
            color: #f1f5f9;
        }
        [data-bs-theme="dark"] .nav-user-pill:hover {
            background: #334155;
            border-color: #475569;
        }
        .nav-user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1f6e52, #134e3b);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .nav-user-avatar.admin-avatar {
            background: linear-gradient(135deg, #4f46e5, #3730a3);
        }
        .nav-user-avatar.farmer-avatar {
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        /* Clean Card Style */
        .card-app {
            background-color: #ffffff;
            border: 1px solid var(--app-card-border);
            border-radius: 8px;
        }

        /* Warm Organic Ivory Promo Card (#FDFBF7) */
        .promo-card-cream {
            background-color: #FDFBF7 !important;
            border: 1px solid #EDE8DF !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .promo-card-cream:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06) !important;
        }

        /* =========================================================
           HIGH CONTRAST PROFESSIONAL DARK THEME SPECIFICATIONS
           ========================================================= */
        [data-bs-theme="dark"] {
            --bs-body-bg: #0b1329;
            --bs-body-color: #f1f5f9;
            --bs-card-bg: #1e293b;
            --bs-card-border-color: #334155;
            --bs-border-color: #334155;
            --bs-border-color-translucent: rgba(255, 255, 255, 0.12);
        }

        [data-bs-theme="dark"] body {
            background-color: #0b1329 !important;
            color: #f1f5f9 !important;
        }

        /* Dark Mode Headings */
        [data-bs-theme="dark"] h1, 
        [data-bs-theme="dark"] h2, 
        [data-bs-theme="dark"] h3, 
        [data-bs-theme="dark"] h4, 
        [data-bs-theme="dark"] h5, 
        [data-bs-theme="dark"] h6,
        [data-bs-theme="dark"] .h1, 
        [data-bs-theme="dark"] .h2, 
        [data-bs-theme="dark"] .h3, 
        [data-bs-theme="dark"] .h4, 
        [data-bs-theme="dark"] .h5, 
        [data-bs-theme="dark"] .h6 {
            color: #f8fafc !important;
        }

        /* Dark Mode Text Colors */
        [data-bs-theme="dark"] .text-dark,
        [data-bs-theme="dark"] .text-dark-emphasis {
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] a.text-dark,
        [data-bs-theme="dark"] a.text-dark-emphasis,
        [data-bs-theme="dark"] .text-dark a,
        [data-bs-theme="dark"] .text-dark-emphasis a {
            color: #f8fafc !important;
        }

        [data-bs-theme="dark"] a.text-dark:hover,
        [data-bs-theme="dark"] a.text-dark-emphasis:hover,
        [data-bs-theme="dark"] .text-dark a:hover {
            color: #86efac !important;
        }

        [data-bs-theme="dark"] .text-secondary,
        [data-bs-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }

        [data-bs-theme="dark"] .lead {
            color: #cbd5e1 !important;
        }

        /* Dark Mode Cards & Surfaces */
        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] .card-app,
        [data-bs-theme="dark"] .card-custom,
        [data-bs-theme="dark"] .promo-card-cream {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }

        [data-bs-theme="dark"] .card-body {
            color: #f1f5f9 !important;
        }

        [data-bs-theme="dark"] .bg-light,
        [data-bs-theme="dark"] .bg-white {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }

        [data-bs-theme="dark"] .border,
        [data-bs-theme="dark"] .border-top,
        [data-bs-theme="dark"] .border-bottom,
        [data-bs-theme="dark"] .border-start,
        [data-bs-theme="dark"] .border-end {
            border-color: #334155 !important;
        }

        /* Dark Mode Tables & Lists */
        [data-bs-theme="dark"] .table {
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }
        [data-bs-theme="dark"] .table > :not(caption) > * > * {
            background-color: transparent !important;
            color: #f1f5f9 !important;
            border-bottom-color: #334155 !important;
        }
        [data-bs-theme="dark"] .list-group-item {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }

        /* Dark Mode Form Controls */
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            border-color: #22c55e !important;
            box-shadow: 0 0 0 0.2rem rgba(34, 197, 94, 0.2) !important;
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] .form-control::placeholder {
            color: #64748b !important;
        }

        /* Dark Mode Badges & Buttons */
        [data-bs-theme="dark"] .btn-light {
            background-color: #334155 !important;
            border-color: #475569 !important;
            color: #f8fafc !important;
        }
        [data-bs-theme="dark"] .btn-light:hover {
            background-color: #475569 !important;
            color: #ffffff !important;
        }
        [data-bs-theme="dark"] .btn-outline-secondary {
            border-color: #475569 !important;
            color: #cbd5e1 !important;
        }
        [data-bs-theme="dark"] .btn-outline-secondary:hover {
            background-color: #334155 !important;
            border-color: #64748b !important;
            color: #ffffff !important;
        }
        [data-bs-theme="dark"] .badge.bg-secondary-subtle {
            background-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        [data-bs-theme="dark"] .badge.bg-success-subtle {
            background-color: rgba(34, 197, 94, 0.2) !important;
            color: #86efac !important;
            border-color: rgba(34, 197, 94, 0.3) !important;
        }
        [data-bs-theme="dark"] .badge.bg-light {
            background-color: #334155 !important;
            color: #f8fafc !important;
            border-color: #475569 !important;
        }

        /* Dark Mode Dropdowns */
        [data-bs-theme="dark"] .dropdown-menu {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
        }
        [data-bs-theme="dark"] .dropdown-item {
            color: #e2e8f0 !important;
        }
        [data-bs-theme="dark"] .dropdown-item:hover,
        [data-bs-theme="dark"] .dropdown-item:focus {
            background-color: #334155 !important;
            color: #86efac !important;
        }
        [data-bs-theme="dark"] .dropdown-divider {
            border-color: #334155 !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--app-primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(21, 128, 61, 0.15) !important;
        }

        /* Top Accessibility Bar */
        .top-bar {
            background-color: var(--app-dark);
            color: #94a3b8;
            font-size: 0.8rem;
            padding: 5px 0;
        }

        /* Footer with Fresh Vegetables Background Overlay */
        .footer-main {
            margin-top: auto;
            background-image: linear-gradient(180deg, rgba(15, 23, 42, 0.90) 0%, rgba(15, 23, 42, 0.96) 100%), url('{{ asset('images/site/footer_vegetables.jpg') }}');
            background-size: cover;
            background-position: center bottom;
            color: #cbd5e1;
            padding: 3.5rem 0 1.75rem;
            border-top: 2px solid rgba(37, 96, 82, 0.4);
            position: relative;
        }

        .footer-main h5, .footer-main h6 {
            color: #ffffff !important;
            letter-spacing: 0.2px;
        }

        .footer-main .text-secondary {
            color: #94a3b8 !important;
            transition: all 0.2s ease;
        }

        .footer-main a.text-secondary:hover {
            color: #86efac !important;
            padding-left: 3px;
        }

        .footer-main hr {
            border-color: rgba(255, 255, 255, 0.12) !important;
        }

        .footer-feature-badge {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 0.82rem;
            color: #f1f5f9;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            transition: all 0.2s ease;
        }
        .footer-feature-badge:hover {
            background: rgba(37, 96, 82, 0.45);
            border-color: #34d399;
            transform: translateY(-1px);
        }

        /* Floating Chatbot Button */
        .chat-toggle-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background-color: var(--app-primary);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            z-index: 1040;
            border: none;
        }
        .chat-toggle-btn:hover {
            background-color: var(--app-primary-hover);
            color: #ffffff;
        }

        /* Modern Floating Toast Notifications */
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
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideInToast 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        @keyframes slideInToast {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
    @yield('styles')
</head>
<body class="font-md">

    <!-- Main Navigation Bar with Proper Linked Icons -->
    <nav class="navbar navbar-expand-lg navbar-main sticky-top">
        <div class="container">
            <a class="navbar-brand brand-title d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('images/site/logo.png') }}?v=3" alt="MarketLink" style="width: 38px; height: 38px; object-fit: contain;">
                <span>MarketLink</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active text-success fw-bold' : 'text-secondary' }}" href="{{ route('home') }}">
                            <i class="fa-solid fa-house text-success"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active text-success fw-bold' : 'text-secondary' }}" href="{{ route('products.index') }}">
                            <i class="fa-solid fa-carrot text-secondary"></i> Produce Catalog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('markets.*') ? 'active text-success fw-bold' : 'text-secondary' }}" href="{{ route('markets.index') }}">
                            <i class="fa-solid fa-location-dot text-secondary"></i> Markets & Map
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('farmers.*') ? 'active text-success fw-bold' : 'text-secondary' }}" href="{{ route('farmers.index') }}">
                            <i class="fa-solid fa-store text-secondary"></i> Farmers & Stalls
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active text-success fw-bold' : 'text-secondary' }}" href="{{ route('about') }}">
                            <i class="fa-solid fa-circle-info text-secondary"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active text-success fw-bold' : 'text-secondary' }}" href="{{ route('contact') }}">
                            <i class="fa-solid fa-envelope text-secondary"></i> Contact
                        </a>
                    </li>
                </ul>

                <div class="nav-actions-group">
                    <!-- Theme Mode Toggle -->
                    <button type="button" class="nav-icon-action" id="themeToggleBtn" onclick="toggleDarkMode()" title="Toggle Dark/Light Mode">
                        <i class="fa-regular fa-moon fs-6" id="themeIcon"></i>
                    </button>

                    @guest
                        <!-- Cart Button for Guests -->
                        <a href="{{ route('cart.index') }}" class="nav-icon-action position-relative" title="View Shopping Basket">
                            <i class="fa-solid fa-cart-shopping fs-6"></i>
                            @php $cartCount = count(session('cart', [])); @endphp
                            <span class="cart-badge-dot {{ $cartCount > 0 ? '' : 'd-none' }}" id="cartBadgeCount">
                                {{ $cartCount }}
                            </span>
                        </a>

                        <div class="vr mx-1 opacity-25 d-none d-sm-block" style="height: 24px;"></div>

                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('login') }}" class="btn btn-outline-app px-3 btn-sm text-nowrap">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-primary-app px-3 btn-sm text-nowrap">Register</a>
                        </div>
                    @endguest

                    @auth
                        @if(Auth::user()->isAdmin())
                            <!-- Admin Compact User Pill with Fast Dropdown -->
                            <div class="dropdown">
                                <button class="nav-user-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="nav-user-avatar admin-avatar">
                                        <i class="fa-solid fa-shield-halved" style="font-size: 0.75rem;"></i>
                                    </span>
                                    <span class="fw-semibold text-nowrap">{{ Auth::user()->name }}</span>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-0.5 rounded-pill" style="font-size: 0.65rem;">Admin</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 py-2" style="min-width: 220px; border-radius: 8px;">
                                    <li class="px-3 py-2 border-bottom mb-1">
                                        <div class="fw-bold text-dark fs-6">{{ Auth::user()->name }}</div>
                                        <small class="text-muted d-block text-truncate">{{ Auth::user()->email }}</small>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 fw-semibold text-success d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                                            <i class="fa-solid fa-chart-line text-success"></i> Admin Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('profile') }}">
                                            <i class="fa-solid fa-gear text-secondary"></i> Account Settings
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @elseif(Auth::user()->isFarmer())
                            <!-- Farmer Compact User Pill with Portal Access -->
                            <div class="dropdown">
                                <button class="nav-user-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="nav-user-avatar farmer-avatar">
                                        <i class="fa-solid fa-tractor" style="font-size: 0.75rem;"></i>
                                    </span>
                                    <span class="fw-semibold text-nowrap">{{ Auth::user()->name }}</span>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5 rounded-pill" style="font-size: 0.65rem;">Farmer</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 py-2" style="min-width: 220px; border-radius: 8px;">
                                    <li class="px-3 py-2 border-bottom mb-1">
                                        <div class="fw-bold text-dark fs-6">{{ Auth::user()->name }}</div>
                                        <small class="text-muted d-block text-truncate">{{ Auth::user()->email }}</small>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 fw-semibold text-success d-flex align-items-center gap-2" href="{{ route('farmer.dashboard') }}">
                                            <i class="fa-solid fa-gauge-high text-success"></i> Farmer Portal
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('farmer.products.index') }}">
                                            <i class="fa-solid fa-boxes-stacked text-secondary"></i> My Produce
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('farmer.orders.index') }}">
                                            <i class="fa-solid fa-receipt text-secondary"></i> Incoming Orders
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('profile') }}">
                                            <i class="fa-solid fa-gear text-secondary"></i> Account Settings
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <!-- Customer Navbar with Cart & Profile -->
                            <a href="{{ route('cart.index') }}" class="nav-icon-action position-relative" title="View Shopping Basket">
                                <i class="fa-solid fa-cart-shopping fs-6"></i>
                                @php $cartCount = count(session('cart', [])); @endphp
                                <span class="cart-badge-dot {{ $cartCount > 0 ? '' : 'd-none' }}" id="cartBadgeCount">
                                    {{ $cartCount }}
                                </span>
                            </a>

                            <div class="vr mx-1 opacity-25 d-none d-sm-block" style="height: 24px;"></div>

                            <div class="dropdown">
                                <button class="nav-user-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="nav-user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    <span class="fw-semibold text-nowrap">{{ Auth::user()->name }}</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 py-2" style="min-width: 200px; border-radius: 8px;">
                                    <li class="px-3 py-2 border-bottom mb-1">
                                        <div class="fw-bold text-dark fs-6">{{ Auth::user()->name }}</div>
                                        <small class="text-muted d-block text-truncate">{{ Auth::user()->email }}</small>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('customer.orders') }}">
                                            <i class="fa-solid fa-bag-shopping text-secondary"></i> My Pre-Orders
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('favorites.index') }}">
                                            <i class="fa-solid fa-heart text-danger"></i> Saved Favorites
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item py-2 d-flex align-items-center gap-2" href="{{ route('profile') }}">
                                            <i class="fa-solid fa-gear text-secondary"></i> Account Settings
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item py-2 text-danger d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Floating Toast Notifications -->
    <div class="app-toast-container">
        @if(session('success'))
            <div class="app-toast" id="toastSuccess">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-success"><i class="fi fi-rr-check fs-5"></i></span>
                    <span class="small">{{ session('success') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white small ms-3" onclick="dismissToast('toastSuccess')"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="app-toast" id="toastError">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-danger"><i class="fi fi-rr-cross-circle fs-5"></i></span>
                    <span class="small">{{ session('error') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white small ms-3" onclick="dismissToast('toastError')"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="app-toast" id="toastInfo">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-info"><i class="fi fi-rr-info fs-5"></i></span>
                    <span class="small">{{ session('info') }}</span>
                </div>
                <button type="button" class="btn-close btn-close-white small ms-3" onclick="dismissToast('toastInfo')"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-main">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('images/site/logo.png') }}" alt="MarketLink" class="rounded-circle shadow-sm" style="width: 36px; height: 36px; object-fit: cover; background: #fff; padding: 1px;">
                        <h5 class="fw-bold text-white mb-0">MarketLink</h5>
                    </div>
                    <p class="small text-secondary mb-3">
                        Online pre-ordering platform for local farmers markets. Browse live weekly harvest, select pickup dates, and collect fresh produce directly from farm stalls.
                    </p>
                </div>

                <div class="col-lg-2 col-md-6 col-6">
                    <h6 class="fw-bold text-white mb-3">Navigation</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-secondary text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-secondary text-decoration-none">Produce Catalog</a></li>
                        <li class="mb-2"><a href="{{ route('markets.index') }}" class="text-secondary text-decoration-none">Markets Map</a></li>
                        <li class="mb-2"><a href="{{ route('farmers.index') }}" class="text-secondary text-decoration-none">Farmers & Stalls</a></li>
                        <li class="mb-2"><a href="{{ route('sitemap') }}" class="text-secondary text-decoration-none">Sitemap</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 col-6">
                    <h6 class="fw-bold text-white mb-3">Farmers</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('register', ['role' => 'farmer']) }}" class="text-secondary text-decoration-none">Register as Farmer</a></li>
                        <li class="mb-2"><a href="{{ route('login') }}" class="text-secondary text-decoration-none">Farmer Login</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}" class="text-secondary text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="{{ route('contact') }}" class="text-secondary text-decoration-none">Help & Support</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-white mb-3">Community Hub</h6>
                    <div class="footer-feature-badge">
                        <i class="fi fi-sr-leaf text-success"></i>
                        <span>100% Direct from Farm</span>
                    </div>
                    <div class="footer-feature-badge">
                        <i class="fi fi-sr-shopping-bag text-success"></i>
                        <span>Weekend Stall Pre-Orders</span>
                    </div>
                    <div class="footer-feature-badge">
                        <i class="fi fi-sr-shield-check text-success"></i>
                        <span>Pay in Person at Pickup</span>
                    </div>
                    <div class="footer-feature-badge">
                        <i class="fi fi-sr-marker text-success"></i>
                        <span>Karachi, Lahore & Islamabad</span>
                    </div>
                </div>
            </div>

            <hr class="border-secondary my-4">

            <div class="d-flex flex-wrap justify-content-between align-items-center small text-secondary">
                <div>&copy; {{ date('Y') }} MarketLink. All rights reserved.</div>
                <div>Connecting Local Farmers & Communities</div>
            </div>
        </div>
    </footer>

    <!-- Chatbot Floating Button -->
    <button type="button" class="chat-toggle-btn" data-bs-toggle="modal" data-bs-target="#chatModal" title="Help Assistant">
        <i class="fa-solid fa-comments fs-5"></i>
    </button>

    <!-- Chatbot Modal -->
    <div class="modal fade" id="chatModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom-right" style="max-width: 400px;">
            <div class="modal-content border-0 shadow" style="border-radius: 8px;">
                <div class="modal-header bg-dark text-white py-2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-headset text-success"></i>
                        <h6 class="modal-title mb-0 fw-bold">MarketLink Assistant</h6>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3 bg-light" id="chatMessages" style="height: 320px; overflow-y: auto;">
                    <div class="d-flex gap-2 mb-3">
                        <div class="bg-white p-2 rounded border small text-dark" style="max-width: 85%;">
                            Hello! I am your MarketLink Assistant. Ask me about fresh vegetables, market locations, pickup schedules, or pre-ordering.
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-2 bg-white">
                    <form id="chatForm" class="d-flex w-100 gap-2" onsubmit="handleChatSubmit(event)">
                        <input type="text" id="chatInput" class="form-control form-control-sm" placeholder="Ask a question..." required>
                        <button type="submit" class="btn btn-sm btn-primary-app"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Font size adjuster
        function setFontSize(sizeClass) {
            document.body.classList.remove('font-sm', 'font-md', 'font-lg');
            document.body.classList.add(sizeClass);
            localStorage.setItem('marketlink_font_size', sizeClass);
        }

        // Dark mode toggle
        function toggleDarkMode() {
            const html = document.documentElement;
            const current = html.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', next);
            localStorage.setItem('marketlink_theme', next);
            updateThemeButton(next);
        }

        function updateThemeButton(theme) {
            const btn = document.getElementById('themeToggleBtn');
            if (!btn) return;
            if (theme === 'dark') {
                btn.innerHTML = '<i class="fa-solid fa-sun text-warning fs-6"></i>';
                btn.title = 'Switch to Light Mode';
            } else {
                btn.innerHTML = '<i class="fa-regular fa-moon fs-6"></i>';
                btn.title = 'Switch to Dark Mode';
            }
        }

        // Init theme & font size on load
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('marketlink_theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            updateThemeButton(savedTheme);

            const savedFont = localStorage.getItem('marketlink_font_size') || 'font-md';
            document.body.classList.remove('font-sm', 'font-md', 'font-lg');
            document.body.classList.add(savedFont);
        });

        // Chatbot AJAX handler
        function handleChatSubmit(e) {
            e.preventDefault();
            const input = document.getElementById('chatInput');
            const message = input.value.trim();
            if (!message) return;

            const chatMessages = document.getElementById('chatMessages');

            // Append user message
            const userMsg = document.createElement('div');
            userMsg.className = 'd-flex justify-content-end mb-2';
            userMsg.innerHTML = `<div class="bg-dark text-white p-2 rounded small" style="max-width: 85%;">${escapeHtml(message)}</div>`;
            chatMessages.appendChild(userMsg);
            input.value = '';
            chatMessages.scrollTop = chatMessages.scrollHeight;

            // Loading state
            const loading = document.createElement('div');
            loading.className = 'd-flex gap-2 mb-2 text-muted small';
            loading.innerHTML = `<span>Searching...</span>`;
            chatMessages.appendChild(loading);
            chatMessages.scrollTop = chatMessages.scrollHeight;

            fetch("{{ route('api.chatbot') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message })
            })
            .then(res => res.json())
            .then(data => {
                loading.remove();
                const botMsg = document.createElement('div');
                botMsg.className = 'd-flex gap-2 mb-2';
                botMsg.innerHTML = `<div class="bg-white p-2 rounded border small text-dark" style="max-width: 85%;">${data.response}</div>`;
                chatMessages.appendChild(botMsg);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            })
            .catch(() => {
                loading.remove();
                const botMsg = document.createElement('div');
                botMsg.className = 'd-flex gap-2 mb-2';
                botMsg.innerHTML = `<div class="bg-white p-2 rounded border small text-danger" style="max-width: 85%;">Error connecting to server. Please try again.</div>`;
                chatMessages.appendChild(botMsg);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            });
        }

        function escapeHtml(str) {
            const d = document.createElement('div');
            d.innerText = str;
            return d.innerHTML;
        }

        // Toggle Favorite AJAX
        function toggleFavorite(type, id, btn) {
            fetch("{{ route('favorites.toggle') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ type: type, target_id: id })
            })
            .then(res => {
                if (res.status === 401) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                return res.json();
            })
            .then(data => {
                if (data && data.success) {
                    const icon = btn.querySelector('i');
                    if (data.status === 'added') {
                        icon.className = 'fi fi-sr-heart text-danger';
                    } else {
                        icon.className = 'fi fi-rr-heart';
                    }
                }
            });
        }

        // Dynamic Toast Notification Generator
        function showToast(message, type = 'success') {
            let container = document.getElementById('toastNotificationArea');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastNotificationArea';
                container.style.cssText = 'position: fixed; top: 80px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; max-width: 350px;';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            const bgClass = type === 'success' ? 'bg-success text-white' : 'bg-danger text-white';
            const iconClass = type === 'success' ? 'fi fi-rr-check-circle' : 'fi fi-rr-cross-circle';
            
            toast.className = `p-3 rounded shadow-lg d-flex align-items-center justify-content-between ${bgClass}`;
            toast.style.cssText = 'transition: all 0.3s ease; animation: slideInToast 0.3s ease;';
            toast.innerHTML = `
                <div class="d-flex align-items-center gap-2">
                    <i class="${iconClass} fs-5"></i>
                    <div>
                        <strong class="d-block small">${type === 'success' ? 'Basket Updated' : 'Notice'}</strong>
                        <span class="small">${escapeHtml(message)}</span>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white ms-2" onclick="this.parentElement.remove()"></button>
            `;

            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 350);
            }, 3500);
        }

        // Real-time Cart Badge Updater
        function updateCartBadge(count) {
            const badge = document.getElementById('cartBadgeCount');
            if (badge) {
                badge.innerText = count;
                if (count > 0) {
                    badge.classList.remove('d-none');
                    badge.style.display = 'inline-flex';
                } else {
                    badge.classList.add('d-none');
                    badge.style.display = 'none';
                }
            }
        }

        // Global AJAX Add to Cart (Zero Full Page Reload)
        function handleAddToCart(event, form) {
            event.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            const origHtml = btn ? btn.innerHTML : '';
            
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span>';
            }

            const formData = new FormData(form);

            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(result => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = origHtml;
                }
                if (result.status >= 200 && result.status < 300 && result.body.success) {
                    updateCartBadge(result.body.cartCount);
                    showToast(result.body.message, 'success');
                    if (btn) {
                        btn.innerHTML = '<i class="fi fi-rr-check text-white"></i> Added';
                        btn.classList.add('btn-success');
                        setTimeout(() => {
                            btn.innerHTML = origHtml;
                            btn.classList.remove('btn-success');
                        }, 1200);
                    }
                } else {
                    showToast(result.body.message || 'Could not add product to basket.', 'error');
                }
            })
            .catch(err => {
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = origHtml;
                }
                showToast('Network error, please try again.', 'error');
            });

            return false;
        }

        // Toast Notification Dismissal
        function dismissToast(id) {
            const el = document.getElementById(id);
            if (el) {
                el.style.opacity = '0';
                el.style.transform = 'translateX(100%)';
                setTimeout(() => el.remove(), 300);
            }
        }

        // Auto-dismiss toasts after 4.5 seconds
        document.addEventListener('DOMContentLoaded', () => {
            ['toastSuccess', 'toastError', 'toastInfo'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    setTimeout(() => {
                        dismissToast(id);
                    }, 4500);
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
