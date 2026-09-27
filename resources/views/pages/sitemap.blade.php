@extends('layouts.app')

@section('title', 'Application Sitemap - MarketLink Flow')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Application Sitemap</li>
        </ol>
    </nav>

    <div class="mb-4">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold mb-2">SRS Project Deliverable</span>
        <h2 class="fw-bold">MarketLink Architecture & Navigation Sitemap</h2>
        <p class="text-muted">A structured overview of all functional endpoints and multi-role user flows across the platform.</p>
    </div>

    <div class="row g-4">
        <!-- Public Endpoints -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-custom h-100 p-4 border-0 shadow-sm">
                <div class="text-success mb-3"><i class="bi bi-globe fs-3"></i></div>
                <h5 class="fw-bold">1. Public Portal</h5>
                <ul class="list-unstyled small mt-3">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none text-dark-emphasis">• Landing Home Page</a></li>
                    <li class="mb-2"><a href="{{ route('products.index') }}" class="text-decoration-none text-dark-emphasis">• Produce Catalog (Filters & Search)</a></li>
                    <li class="mb-2"><a href="{{ route('markets.index') }}" class="text-decoration-none text-dark-emphasis">• Interactive Markets Map</a></li>
                    <li class="mb-2"><a href="{{ route('farmers.index') }}" class="text-decoration-none text-dark-emphasis">• Verified Farmers Directory</a></li>
                    <li class="mb-2"><a href="{{ route('cart.index') }}" class="text-decoration-none text-dark-emphasis">• Pre-Order Cart / Basket</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-decoration-none text-dark-emphasis">• About Platform</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-decoration-none text-dark-emphasis">• Contact & Helpline</a></li>
                </ul>
            </div>
        </div>

        <!-- Customer Endpoints -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-custom h-100 p-4 border-0 shadow-sm">
                <div class="text-primary mb-3"><i class="bi bi-person-badge fs-3"></i></div>
                <h5 class="fw-bold">2. Customer Portal</h5>
                <ul class="list-unstyled small mt-3">
                    <li class="mb-2"><a href="{{ route('login') }}" class="text-decoration-none text-dark-emphasis">• Customer Login</a></li>
                    <li class="mb-2"><a href="{{ route('register', ['role' => 'customer']) }}" class="text-decoration-none text-dark-emphasis">• Customer Registration</a></li>
                    <li class="mb-2"><a href="{{ route('customer.checkout') }}" class="text-decoration-none text-dark-emphasis">• Date & Time Slot Checkout</a></li>
                    <li class="mb-2"><a href="{{ route('customer.orders') }}" class="text-decoration-none text-dark-emphasis">• My Pre-Orders History</a></li>
                    <li class="mb-2"><a href="{{ route('favorites.index') }}" class="text-decoration-none text-dark-emphasis">• Saved Favorite Farmers & Produce</a></li>
                    <li class="mb-2"><a href="{{ route('profile') }}" class="text-decoration-none text-dark-emphasis">• Profile & Password Settings</a></li>
                </ul>
            </div>
        </div>

        <!-- Farmer Portal -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-custom h-100 p-4 border-0 shadow-sm">
                <div class="text-success mb-3"><i class="bi bi-shop fs-3"></i></div>
                <h5 class="fw-bold">3. Farmer (Vendor) Portal</h5>
                <ul class="list-unstyled small mt-3">
                    <li class="mb-2"><a href="{{ route('register', ['role' => 'farmer']) }}" class="text-decoration-none text-dark-emphasis">• Farmer Registration Flow</a></li>
                    <li class="mb-2"><a href="{{ route('farmer.dashboard') }}" class="text-decoration-none text-dark-emphasis">• Farmer Dashboard & Analytics</a></li>
                    <li class="mb-2"><a href="{{ route('farmer.products.index') }}" class="text-decoration-none text-dark-emphasis">• Weekly Stock Management</a></li>
                    <li class="mb-2"><a href="{{ route('farmer.products.create') }}" class="text-decoration-none text-dark-emphasis">• Add Produce Item</a></li>
                    <li class="mb-2"><a href="{{ route('farmer.orders.index') }}" class="text-decoration-none text-dark-emphasis">• Incoming Pre-Orders (Accept/Ready)</a></li>
                    <li class="mb-2"><a href="{{ route('farmer.profile.edit') }}" class="text-decoration-none text-dark-emphasis">• Stall & Pickup Hours Configuration</a></li>
                    <li class="mb-2"><a href="{{ route('farmer.reviews.index') }}" class="text-decoration-none text-dark-emphasis">• Customer Feedback & Replies</a></li>
                </ul>
            </div>
        </div>

        <!-- Admin Control Panel -->
        <div class="col-md-6 col-lg-3">
            <div class="card card-custom h-100 p-4 border-0 shadow-sm">
                <div class="text-danger mb-3"><i class="bi bi-shield-lock fs-3"></i></div>
                <h5 class="fw-bold">4. Administrator Portal</h5>
                <ul class="list-unstyled small mt-3">
                    <li class="mb-2"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-dark-emphasis">• Admin Overview & Statistics</a></li>
                    <li class="mb-2"><a href="{{ route('admin.farmers.index') }}" class="text-decoration-none text-dark-emphasis">• Farmer Verifications & Approvals</a></li>
                    <li class="mb-2"><a href="{{ route('admin.customers.index') }}" class="text-decoration-none text-dark-emphasis">• Customer Account Management</a></li>
                    <li class="mb-2"><a href="{{ route('admin.markets.index') }}" class="text-decoration-none text-dark-emphasis">• Weekend Markets Management</a></li>
                    <li class="mb-2"><a href="{{ route('admin.categories.index') }}" class="text-decoration-none text-dark-emphasis">• Produce Category Master Data</a></li>
                    <li class="mb-2"><a href="{{ route('admin.reports.index') }}" class="text-decoration-none text-dark-emphasis">• Revenue & Order Analytics Reports</a></li>
                    <li class="mb-2"><a href="{{ route('admin.announcements.index') }}" class="text-decoration-none text-dark-emphasis">• System Announcements Manager</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
