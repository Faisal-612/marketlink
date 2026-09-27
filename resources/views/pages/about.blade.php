@extends('layouts.app')

@section('title', 'About MarketLink - Farmers Market Platform')

@section('content')
<div class="container mb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About Us</li>
        </ol>
    </nav>

    <div class="row g-5 align-items-center mb-5">
        <div class="col-lg-6">
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold mb-2">
                Our Story & Purpose
            </span>
            <h1 class="fw-bold mb-3">Fresh Farm Harvests, Directly From Local Growers</h1>
            <p class="lead text-secondary">
                MarketLink was created to bridge the gap between local organic growers and everyday households across Karachi, Lahore, and Islamabad.
            </p>
            <p class="text-secondary">
                Anyone who visits weekend farmers markets knows the common struggle: you drive all the way to Clifton, Gulberg, or F-7 Markaz on Sunday morning, only to find the freshest desi eggs, purple tomatoes, or organic greens already sold out within the first hour.
            </p>
            <p class="text-secondary">
                At the same time, hardworking smallholder farmers often struggle with post-harvest spoilage when they harvest too much produce without knowing exact customer turnout.
            </p>
            <p class="text-secondary">
                MarketLink solves this directly: farmers post their upcoming weekend harvest during the week, customers place pre-orders with convenient pickup time slots, and the farmer harvests fresh at dawn for your reserved crate. No online payment gateways, no middlemen cuts—you inspect your produce and pay directly at the stall.
            </p>
        </div>
        <div class="col-lg-6">
            <img src="{{ asset('images/site/banner_103.jpg') }}" class="img-fluid rounded-4 shadow-sm" alt="Community Farmers Market">
        </div>
    </div>

    <!-- Core Values -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card card-app h-100 p-4 border shadow-sm">
                <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                    <i class="fi fi-sr-shield-check fs-4"></i>
                </div>
                <h5 class="fw-bold text-dark">Pay Directly at the Stall</h5>
                <p class="text-secondary mb-0">Pre-orders are reserved without requiring upfront credit cards or online wallet hassles. You verify the freshness in person and pay cash or card at pickup.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-app h-100 p-4 border shadow-sm">
                <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                    <i class="fi fi-sr-marker fs-4"></i>
                </div>
                <h5 class="fw-bold text-dark">Interactive GPS Market Maps</h5>
                <p class="text-secondary mb-0">Find exact market locations, opening timings, and active stall numbers in Karachi, Lahore, and Islamabad with live OpenStreetMap navigation.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-app h-100 p-4 border shadow-sm">
                <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                    <i class="fi fi-sr-leaf fs-4"></i>
                </div>
                <h5 class="fw-bold text-dark">Zero Food Wastage</h5>
                <p class="text-secondary mb-0">Because growers harvest according to confirmed pre-order demand, unsold surplus produce and food waste are reduced significantly.</p>
            </div>
        </div>
    </div>
</div>
@endsection
