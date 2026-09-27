@extends('layouts.app')

@section('title', 'My Pre-Orders - MarketLink')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Pre-Orders</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-bag-check-fill text-success me-2"></i>My Pre-Orders</h2>
            <p class="text-muted mb-0">Track your upcoming farmers market pickups, past orders, and receipts</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-market btn-sm"><i class="bi bi-plus-lg me-1"></i> New Pre-Order</a>
    </div>

    @if($orders->count() > 0)
        <div class="card card-custom border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Farm Stall & Market</th>
                            <th>Pickup Scheduled</th>
                            <th>Items</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    <strong class="text-dark">{{ $order->order_number }}</strong><br>
                                    <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    <h6 class="fw-bold mb-0 text-success">{{ $order->farmer->farmerProfile->stall_name ?? 'Farm Stall' }}</h6>
                                    <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $order->farmer->farmerProfile->market->name ?? 'Farmers Market' }}</small>
                                </td>
                                <td>
                                    <strong>{{ $order->pickup_date->format('l, M d, Y') }}</strong><br>
                                    <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $order->pickup_time_slot }}</small>
                                </td>
                                <td>{{ $order->items->sum('quantity') }} items</td>
                                <td>
                                    <strong class="text-success">Rs. {{ number_format($order->total_amount, 2) }}</strong><br>
                                    <small class="text-muted">{{ $order->payment_status === 'paid_at_pickup' ? 'Paid at Pickup' : 'Pay at Pickup' }}</small>
                                </td>
                                <td>
                                    <span class="badge {{ $order->status_badge }}">{{ $order->status_label }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('customer.orders.show', $order->id) }}" class="btn btn-sm btn-outline-success">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="card card-custom p-5 border-0 shadow-sm text-center">
            <i class="bi bi-bag-x text-muted" style="font-size: 4rem;"></i>
            <h4 class="fw-bold mt-3">No Pre-Orders Yet</h4>
            <p class="text-muted mb-4">You haven't placed any farmers market pre-orders yet.</p>
            <div>
                <a href="{{ route('products.index') }}" class="btn btn-market px-4">Browse Fresh Produce</a>
            </div>
        </div>
    @endif
</div>
@endsection
