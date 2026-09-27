@extends('layouts.app')

@section('title', 'Order ' . $order->order_number . ' - Details')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.orders') }}" class="text-success text-decoration-none">My Pre-Orders</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $order->order_number }}</li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pre-Order #{{ $order->order_number }}</h2>
            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>
        <div class="d-flex gap-2">
            @if(in_array($order->order_status, ['placed', 'accepted']))
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                    <i class="bi bi-x-circle me-1"></i> Cancel Pre-Order
                </button>
            @endif

            @if($order->order_status === 'completed')
                <button type="button" class="btn btn-warning btn-sm text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#reviewModal">
                    <i class="bi bi-star-fill me-1"></i> Rate & Review Harvest
                </button>
            @endif

            <form action="{{ route('customer.orders.reorder', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-success btn-sm">
                    <i class="bi bi-arrow-repeat me-1"></i> Quick Reorder
                </button>
            </form>
        </div>
    </div>

    <!-- Live Order Tracking Progress Timeline -->
    <div class="card card-custom p-4 border-0 shadow-sm mb-4">
        <h5 class="fw-bold mb-4"><i class="bi bi-truck text-success me-2"></i>Order Status Tracker</h5>
        
        @php
            $statuses = ['placed', 'accepted', 'ready_for_pickup', 'completed'];
            $currentIndex = array_search($order->order_status, $statuses);
            if ($order->order_status === 'cancelled') $currentIndex = -1;
        @endphp

        @if($order->order_status === 'cancelled')
            <div class="alert alert-danger mb-0">
                <i class="bi bi-x-octagon-fill me-2"></i><strong>Order Cancelled:</strong> {{ $order->cancelled_reason ?: 'This pre-order was cancelled.' }}
            </div>
        @else
            <div class="row text-center position-relative">
                <div class="col-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 {{ $currentIndex >= 0 ? 'bg-success text-white' : 'bg-light text-muted' }}" style="width: 45px; height: 45px;">
                        <i class="bi bi-check-lg fs-5"></i>
                    </div>
                    <h6 class="fw-bold mb-0 small">1. Placed</h6>
                    <small class="text-muted">Order received</small>
                </div>
                <div class="col-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 {{ $currentIndex >= 1 ? 'bg-success text-white' : 'bg-light text-muted' }}" style="width: 45px; height: 45px;">
                        <i class="bi bi-shop fs-5"></i>
                    </div>
                    <h6 class="fw-bold mb-0 small">2. Accepted</h6>
                    <small class="text-muted">Farmer packing</small>
                </div>
                <div class="col-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 {{ $currentIndex >= 2 ? 'bg-success text-white' : 'bg-light text-muted' }}" style="width: 45px; height: 45px;">
                        <i class="bi bi-box2-heart fs-5"></i>
                    </div>
                    <h6 class="fw-bold mb-0 small">3. Ready for Pickup</h6>
                    <small class="text-muted">At stall location</small>
                </div>
                <div class="col-3">
                    <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2 {{ $currentIndex >= 3 ? 'bg-success text-white' : 'bg-light text-muted' }}" style="width: 45px; height: 45px;">
                        <i class="bi bi-bag-check-fill fs-5"></i>
                    </div>
                    <h6 class="fw-bold mb-0 small">4. Completed</h6>
                    <small class="text-muted">Picked up & paid</small>
                </div>
            </div>
        @endif
    </div>

    <div class="row g-4">
        <!-- Order Items -->
        <div class="col-lg-8">
            <div class="card card-custom p-4 border-0 shadow-sm mb-4">
                <h5 class="fw-bold mb-3">Harvest Items Ordered</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <h6 class="fw-bold mb-0">{{ $item->product_name }}</h6>
                                        <small class="text-muted">Unit: {{ $item->unit }}</small>
                                    </td>
                                    <td>Rs. {{ number_format($item->unit_price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end fw-bold text-success">Rs. {{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end fs-5">Total Amount Due at Pickup:</th>
                                <th class="text-end fs-5 text-success">Rs. {{ number_format($order->total_amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($order->customer_notes)
                    <div class="bg-light p-3 rounded-3 mt-3">
                        <strong>My Notes:</strong>
                        <p class="text-muted mb-0 small">{{ $order->customer_notes }}</p>
                    </div>
                @endif

                @if($order->farmer_notes)
                    <div class="bg-success-subtle p-3 rounded-3 mt-3 border border-success-subtle">
                        <strong class="text-success"><i class="bi bi-chat-quote-fill me-1"></i> Note from Farmer:</strong>
                        <p class="text-dark mb-0 small">{{ $order->farmer_notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pickup Info & Stall Card -->
        <div class="col-lg-4">
            <div class="card card-custom p-4 border-0 shadow-sm mb-4">
                <h5 class="fw-bold mb-3">Pickup Information</h5>
                
                <div class="mb-3">
                    <small class="text-muted d-block">Scheduled Pickup Day:</small>
                    <strong class="fs-6 text-dark">{{ $order->pickup_date->format('l, M d, Y') }}</strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Selected Time Slot:</small>
                    <strong class="fs-6 text-success"><i class="bi bi-clock me-1"></i>{{ $order->pickup_time_slot }}</strong>
                </div>

                <hr>

                <div class="mb-3">
                    <small class="text-muted d-block">Farmer Stall:</small>
                    <h6 class="fw-bold mb-0 text-success">{{ $order->farmer->farmerProfile->stall_name ?? 'Farmer Stall' }}</h6>
                    <small class="text-muted">Grower: {{ $order->farmer->name }}</small>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Market Location:</small>
                    <p class="mb-0 small text-dark"><strong>{{ $order->farmer->farmerProfile->market->name ?? 'Farmers Market' }}</strong></p>
                    <small class="text-muted">{{ $order->farmer->farmerProfile->market->address ?? '' }}</small>
                </div>

                <div>
                    <small class="text-muted d-block">Stall Number:</small>
                    <span class="badge bg-secondary-subtle text-secondary">{{ $order->farmer->farmerProfile->stall_number ?: 'Main Bay' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('customer.orders.cancel', $order->id) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-danger">Cancel Pre-Order #{{ $order->order_number }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this pre-order? The reserved produce stock will be restored.</p>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Reason for Cancellation</label>
                    <textarea name="reason" class="form-control" rows="2" placeholder="e.g. Schedule changed, unable to visit market..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Order</button>
                <button type="submit" class="btn btn-danger">Confirm Cancellation</button>
            </div>
        </form>
    </div>
</div>

<!-- Review Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('customer.reviews.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-success">Rate & Review Farm Stall</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Rating (1 to 5 Stars)</label>
                    <select name="rating" class="form-select" required>
                        <option value="5">5 Stars - Exceptional Harvest</option>
                        <option value="4">4 Stars - Very Good</option>
                        <option value="3">3 Stars - Average</option>
                        <option value="2">2 Stars - Below Expectation</option>
                        <option value="1">1 Star - Poor</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Your Review / Comments</label>
                    <textarea name="comment" class="form-control" rows="4" placeholder="How was the produce freshness and pickup experience at the stall?" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Submit Review</button>
            </div>
        </form>
    </div>
</div>
@endsection
