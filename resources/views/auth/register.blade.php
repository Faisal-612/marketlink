@extends('layouts.app')

@section('title', 'Create Account - MarketLink')

@section('styles')
<style>
    .auth-page-wrapper {
        min-height: calc(100vh - 180px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2.5rem 0;
    }
    .auth-split-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid var(--app-card-border);
        box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.07);
    }
    [data-bs-theme="dark"] .auth-split-card {
        background: #1e293b;
        border-color: #334155;
    }
    .auth-hero-banner {
        background-image: linear-gradient(180deg, rgba(15, 23, 42, 0.35) 0%, rgba(15, 23, 42, 0.88) 100%), url('{{ asset('images/site/banner_103.jpg') }}');
        background-size: cover;
        background-position: center;
        position: relative;
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 560px;
        border-radius: 16px;
        margin: 12px;
    }
    .back-website-pill {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        color: #ffffff !important;
        border-radius: 50px;
        font-size: 0.82rem;
        padding: 5px 14px;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .back-website-pill:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-1px);
        color: #ffffff;
    }
    .auth-form-pane {
        padding: 2.75rem 3rem;
    }
    @media (max-width: 768px) {
        .auth-form-pane {
            padding: 1.75rem 1.25rem;
        }
    }
    .auth-heading {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin-bottom: 0.35rem;
    }
    [data-bs-theme="dark"] .auth-heading {
        color: #f8fafc;
    }
    .auth-subheading {
        font-size: 0.9rem;
        color: #64748b;
        margin-bottom: 1.5rem;
    }
    [data-bs-theme="dark"] .auth-subheading {
        color: #94a3b8;
    }

    /* Modern Luxury Segmented Pill Switcher (Apple/Stripe Style) */
    .segmented-control-bar {
        background: #f1f5f9;
        border-radius: 12px;
        padding: 4px;
        display: flex;
        gap: 4px;
        margin-bottom: 1.5rem;
        border: 1px solid #e2e8f0;
    }
    [data-bs-theme="dark"] .segmented-control-bar {
        background: #0f172a;
        border-color: #334155;
    }
    .segmented-btn {
        flex: 1;
        border: none;
        background: transparent;
        color: #64748b;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 0.6rem 0.75rem;
        border-radius: 9px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
    }
    .segmented-btn:hover {
        color: #1e293b;
    }
    .segmented-btn.active {
        background: #ffffff;
        color: #256052;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }
    [data-bs-theme="dark"] .segmented-btn.active {
        background: #1e293b;
        color: #34d399;
    }

    .auth-input-field {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        color: #1e293b;
        border-radius: 8px;
        padding: 0.65rem 0.9rem;
        font-size: 0.92rem;
    }
    .auth-input-field:focus {
        background-color: #ffffff;
        border-color: #256052 !important;
        box-shadow: 0 0 0 3px rgba(37, 96, 82, 0.15) !important;
        color: #1e293b;
    }
    [data-bs-theme="dark"] .auth-input-field {
        background-color: #0f172a;
        border-color: #334155;
        color: #f1f5f9;
    }
    .input-group-text-theme {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        color: #64748b;
    }
    [data-bs-theme="dark"] .input-group-text-theme {
        background-color: #0f172a;
        border-color: #334155;
        color: #94a3b8;
    }
    .btn-auth-action {
        background-color: #256052;
        border: none;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 8px;
        padding: 0.65rem 1.75rem;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-auth-action:hover {
        background-color: #1c4b40;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px -4px rgba(37, 96, 82, 0.4);
    }
</style>
@endsection

@section('content')
<div class="container auth-page-wrapper">
    <div class="col-12 col-xl-11">
        <div class="auth-split-card">
            <div class="row g-0 align-items-stretch">
                
                <!-- Left Column: Farm & Soil Visual Banner -->
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="auth-hero-banner">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('images/site/logo.png') }}" alt="MarketLink" class="rounded-circle shadow" style="width: 36px; height: 36px; object-fit: cover; border: 2px solid #ffffff;">
                                <span class="fw-bold text-white fs-5">MarketLink</span>
                            </div>
                            <a href="{{ route('home') }}" class="back-website-pill">
                                Back to website <i class="fi fi-rr-arrow-right small"></i>
                            </a>
                        </div>

                        <div>
                            <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill small mb-2 fw-semibold border border-success border-opacity-25">
                                eGreen Basket Platform
                            </span>
                            <h3 class="fw-bold text-white mb-2" style="font-size: 1.55rem; line-height: 1.3;">
                                Fresh from the Soil, Harvested for You.
                            </h3>
                            <p class="text-light opacity-75 small mb-0">
                                Pre-order organic harvests directly from local growers and pick up freshly boxed crates at your neighborhood weekend farmers market.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Registration Form -->
                <div class="col-lg-7 auth-form-pane d-flex flex-column justify-content-center">
                    
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h2 class="auth-heading">Create an account</h2>
                            <p class="auth-subheading">
                                Already have an account? <a href="{{ route('login') }}" class="text-success text-decoration-none fw-semibold">Log in</a>
                            </p>
                        </div>
                        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill d-lg-none">
                            Back <i class="fi fi-rr-arrow-right small"></i>
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Professional Segmented Pill Control (Replaces bulky cards) -->
                    <div class="segmented-control-bar">
                        <button type="button" class="segmented-btn {{ old('role', 'customer') === 'customer' ? 'active' : '' }}" id="tabCustomer" onclick="switchRole('customer')">
                            <i class="fi fi-sr-shopping-bag"></i> Customer / Shopper
                        </button>
                        <button type="button" class="segmented-btn {{ old('role') === 'farmer' ? 'active' : '' }}" id="tabFarmer" onclick="switchRole('farmer')">
                            <i class="fi fi-sr-shop"></i> Farmer / Stall Owner
                        </button>
                    </div>

                    <form action="{{ route('register') }}" method="POST" id="registerForm">
                        @csrf
                        <input type="hidden" name="role" id="selectedRole" value="{{ old('role', 'customer') }}">
                        
                        <!-- Customer Fields -->
                        <div id="customerFields" style="{{ old('role', 'customer') === 'farmer' ? 'display: none;' : 'display: block;' }}">
                            <div class="row g-2 mb-3">
                                <div class="col-sm-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Full Name</label>
                                    <input type="text" name="customer_name" class="form-control auth-input-field" placeholder="e.g. Ali Khan" value="{{ old('customer_name', old('name')) }}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Phone Number</label>
                                    <input type="text" name="customer_phone" class="form-control auth-input-field" placeholder="0300-1234567" value="{{ old('customer_phone', old('phone')) }}">
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-sm-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Email Address</label>
                                    <input type="email" name="customer_email" class="form-control auth-input-field" placeholder="you@example.com" value="{{ old('customer_email', old('email')) }}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Delivery / Home Address (Optional)</label>
                                    <input type="text" name="customer_address" class="form-control auth-input-field" placeholder="e.g. DHA Phase 6, Karachi" value="{{ old('customer_address', old('address')) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Farmer Stall Fields -->
                        <div id="farmerFields" style="{{ old('role') === 'farmer' ? 'display: block;' : 'display: none;' }}">
                            <div class="row g-2 mb-3">
                                <div class="col-sm-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Farm / Stall Name</label>
                                    <input type="text" name="stall_name" class="form-control auth-input-field" placeholder="e.g. Green Valley Farm" value="{{ old('stall_name') }}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Contact Person Name</label>
                                    <input type="text" name="farmer_name" class="form-control auth-input-field" placeholder="e.g. Tariq Mehmood" value="{{ old('farmer_name', old('name')) }}">
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-sm-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Email Address</label>
                                    <input type="email" name="farmer_email" class="form-control auth-input-field" placeholder="farmer@greenfarms.com" value="{{ old('farmer_email', old('email')) }}">
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Contact Number</label>
                                    <input type="text" name="farmer_phone" class="form-control auth-input-field" placeholder="0321-9876543" value="{{ old('farmer_phone', old('phone')) }}">
                                </div>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-sm-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Associated Farmers Market</label>
                                    <select name="market_id" class="form-select auth-input-field">
                                        <option value="">-- Select Market Location --</option>
                                        @foreach($markets as $market)
                                            <option value="{{ $market->id }}" {{ old('market_id') == $market->id ? 'selected' : '' }}>
                                                {{ $market->name }} ({{ $market->city }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label class="form-label small fw-semibold text-secondary mb-1">Farm / Stall Location Address</label>
                                    <input type="text" name="farmer_address" class="form-control auth-input-field" placeholder="e.g. Malir Countryside, Karachi" value="{{ old('farmer_address', old('address')) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Passwords -->
                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label small fw-semibold text-secondary mb-1">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="regPassword" class="form-control auth-input-field" placeholder="At least 6 characters" required>
                                    <button class="btn input-group-text-theme" type="button" onclick="togglePass('regPassword', this)">
                                        <i class="fi fi-rr-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label small fw-semibold text-secondary mb-1">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="regPasswordConfirm" class="form-control auth-input-field" placeholder="Re-type password" required>
                                    <button class="btn input-group-text-theme" type="button" onclick="togglePass('regPasswordConfirm', this)">
                                        <i class="fi fi-rr-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Terms Checkbox -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="agreeTerms" required checked>
                            <label class="form-check-label text-secondary small" for="agreeTerms">
                                I agree to the <a href="#" class="text-success text-decoration-none">Terms of Service</a> & <a href="#" class="text-success text-decoration-none">Privacy Policy</a>
                            </label>
                        </div>

                        <!-- Hidden fields synced before submit -->
                        <input type="hidden" name="name" id="finalName">
                        <input type="hidden" name="email" id="finalEmail">
                        <input type="hidden" name="phone" id="finalPhone">
                        <input type="hidden" name="address" id="finalAddress">

                        <div>
                            <button type="submit" class="btn btn-auth-action" onclick="prepareSubmit()">
                                Create Account <i class="fi fi-rr-arrow-right"></i>
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchRole(role) {
        document.getElementById('selectedRole').value = role;
        const tabCust = document.getElementById('tabCustomer');
        const tabFarm = document.getElementById('tabFarmer');
        const custFields = document.getElementById('customerFields');
        const farmFields = document.getElementById('farmerFields');

        if (role === 'farmer') {
            tabCust.classList.remove('active');
            tabFarm.classList.add('active');
            custFields.style.display = 'none';
            farmFields.style.display = 'block';
        } else {
            tabFarm.classList.remove('active');
            tabCust.classList.add('active');
            farmFields.style.display = 'none';
            custFields.style.display = 'block';
        }
    }

    function togglePass(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fi fi-rr-eye-crossed';
        } else {
            input.type = 'password';
            icon.className = 'fi fi-rr-eye';
        }
    }

    function prepareSubmit() {
        const isFarmer = document.getElementById('selectedRole').value === 'farmer';
        if (isFarmer) {
            document.getElementById('finalName').value = document.querySelector('input[name="farmer_name"]').value;
            document.getElementById('finalEmail').value = document.querySelector('input[name="farmer_email"]').value;
            document.getElementById('finalPhone').value = document.querySelector('input[name="farmer_phone"]').value;
            document.getElementById('finalAddress').value = document.querySelector('input[name="farmer_address"]').value || 'Karachi, Pakistan';
        } else {
            document.getElementById('finalName').value = document.querySelector('input[name="customer_name"]').value;
            document.getElementById('finalEmail').value = document.querySelector('input[name="customer_email"]').value;
            document.getElementById('finalPhone').value = document.querySelector('input[name="customer_phone"]').value;
            document.getElementById('finalAddress').value = document.querySelector('input[name="customer_address"]').value || 'Karachi, Pakistan';
        }
    }
</script>
@endsection
