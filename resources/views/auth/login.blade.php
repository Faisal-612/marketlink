@extends('layouts.app')

@section('title', 'Log In - MarketLink')

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
        min-height: 520px;
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
    .demo-pill {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 0.78rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .demo-pill:hover {
        background: #256052;
        border-color: #256052;
        color: #ffffff;
    }
    [data-bs-theme="dark"] .demo-pill {
        background: #0f172a;
        border-color: #334155;
        color: #cbd5e1;
    }
</style>
@endsection

@section('content')
<div class="container auth-page-wrapper">
    <div class="col-12 col-xl-10 col-lg-11">
        <div class="auth-split-card">
            <div class="row g-0 align-items-stretch">
                
                <!-- Left Column: Farm & Soil Visual Banner -->
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="auth-hero-banner">
                        <!-- Top Header with Logo & Back Button -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('images/site/logo.png') }}" alt="MarketLink" class="rounded-circle shadow" style="width: 36px; height: 36px; object-fit: cover; border: 2px solid #ffffff;">
                                <span class="fw-bold text-white fs-5">MarketLink</span>
                            </div>
                            <a href="{{ route('home') }}" class="back-website-pill">
                                Back to website <i class="fi fi-rr-arrow-right small"></i>
                            </a>
                        </div>

                        <!-- Bottom Typography -->
                        <div>
                            <span class="badge bg-success-subtle text-success px-3 py-1 rounded-pill small mb-2 fw-semibold border border-success border-opacity-25">
                                Verified Farmers Network
                            </span>
                            <h3 class="fw-bold text-white mb-2" style="font-size: 1.55rem; line-height: 1.3;">
                                Fresh from the Soil, Harvested for You.
                            </h3>
                            <p class="text-light opacity-75 small mb-0">
                                Connect with verified local growers, manage weekly produce inventories, or track your market stall pickups in real time.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Login Form -->
                <div class="col-lg-7 auth-form-pane d-flex flex-column justify-content-center">
                    
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h2 class="auth-heading">Welcome back</h2>
                            <p class="auth-subheading">
                                Don't have an account? <a href="{{ route('register') }}" class="text-success text-decoration-none fw-semibold">Register here</a>
                            </p>
                        </div>
                        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-secondary rounded-pill d-lg-none">
                            Back <i class="fi fi-rr-arrow-right small"></i>
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show small py-2 px-3 mb-3" role="alert">
                            <i class="fi fi-rr-check me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show small py-2 px-3 mb-3" role="alert">
                            <i class="fi fi-rr-cross-circle me-1"></i> {{ session('error') }}
                            <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label small fw-semibold text-secondary mb-1">Email Address</label>
                            <input type="email" name="email" id="loginEmail" class="form-control auth-input-field" placeholder="name@example.com" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small fw-semibold text-secondary mb-1">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="loginPassword" class="form-control auth-input-field" placeholder="Enter your password" required>
                                <button class="btn input-group-text-theme" type="button" onclick="togglePass('loginPassword', this)">
                                    <i class="fi fi-rr-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                                <label class="form-check-label text-secondary small" for="rememberMe">
                                    Remember me
                                </label>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <button type="submit" class="btn btn-auth-action">
                                Log In <i class="fi fi-rr-arrow-right"></i>
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
</script>
@endsection
