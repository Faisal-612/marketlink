@extends('layouts.farmer')

@section('title', 'Pre-Order #' . $order->order_number)
@section('page-title', 'Manage Pre-Order #' . $order->order_number)

@section('content')
<div class="row g-4 mb-4">
    <!-- Order Details & Items -->
    <div class="col-lg-7">
        <div class="card card-stat border-0 shadow-sm p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Order Items</h5>
                <span class="badge {{ $order->status_badge }} fs-6">{{ $order->status_label }}</span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->product_name }}</strong><br>
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
                            <th colspan="3" class="text-end fs-5">Total Amount:</th>
                            <th class="text-end fs-5 text-success">Rs. {{ number_format($order->total_amount, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($order->customer_notes)
                <div class="bg-light p-3 rounded-3 mt-3">
                    <strong class="text-muted small">Customer Special Instructions:</strong>
                    <p class="mb-0">{{ $order->customer_notes }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Processing Actions & Customer Info -->
    <div class="col-lg-5">
        <!-- Process Status Form -->
        <div class="card card-stat border-0 shadow-sm p-4 mb-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-arrow-repeat text-success me-1"></i> Update Order Status</h5>
            
            <form action="{{ route('farmer.orders.update_status', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Order Action / Status</label>
                    <select name="order_status" class="form-select" required>
                        <option value="accepted" {{ $order->order_status === 'accepted' ? 'selected' : '' }}>Accept Order (Harvest & Packing)</option>
                        <option value="ready_for_pickup" {{ $order->order_status === 'ready_for_pickup' ? 'selected' : '' }}>Mark Ready for Pickup at Stall</option>
                        <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Mark Completed (Customer Collected & Paid)</option>
                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancel Order (Item Stock Restored)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Note / Instructions for Customer</label>
                    <textarea name="farmer_notes" class="form-control" rows="3" placeholder="e.g. Your fresh produce is packed in paper bag at Stall A-12...">{{ $order->farmer_notes }}</textarea>
                </div>

                <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                    <i class="bi bi-check2-circle me-1"></i> Update Order Status
                </button>
            </form>
        </div>

        <!-- Customer Card -->
        <div class="card card-stat border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-3">Customer Information</h5>
            <p class="mb-1"><strong>Name:</strong> {{ $order->customer->name ?? 'Customer' }}</p>
            <p class="mb-1"><strong>Phone:</strong> {{ $order->customer->phone ?? 'N/A' }}</p>
            <p class="mb-1"><strong>Email:</strong> {{ $order->customer->email ?? 'N/A' }}</p>
            <p class="mb-3"><strong>Address:</strong> {{ $order->customer->address ?? 'N/A' }}</p>
            <hr>
            <div class="small">
                <strong>Scheduled Pickup:</strong><br>
                📅 {{ $order->pickup_date->format('l, M d, Y') }}<br>
                ⏰ {{ $order->pickup_time_slot }}
            </div>
        </div>
    </div>
</div>
@endsection
