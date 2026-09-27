@extends('layouts.farmer')

@section('title', 'Incoming Pre-Orders')
@section('page-title', 'Manage Incoming Customer Pre-Orders')

@section('content')
<div class="card card-stat border-0 shadow-sm p-3 mb-4">
    <form action="{{ route('farmer.orders.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-4">
            <select name="status" class="form-select form-select-sm">
                <option value="">-- All Order Statuses --</option>
                <option value="placed" {{ request('status') === 'placed' ? 'selected' : '' }}>New Placed</option>
                <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="ready_for_pickup" {{ request('status') === 'ready_for_pickup' ? 'selected' : '' }}>Ready for Pickup</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="date" name="date" class="form-control form-control-sm" value="{{ request('date') }}" placeholder="Filter by pickup date">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-success flex-grow-1">Filter Orders</button>
            <a href="{{ route('farmer.orders.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

<div class="card card-stat border-0 shadow-sm overflow-hidden p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order #</th>
                    <th>Customer Name</th>
                    <th>Contact Phone</th>
                    <th>Pickup Scheduled</th>
                    <th>Items</th>
                    <th>Total Due</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong>{{ $order->order_number }}</strong><br>
                            <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                        </td>
                        <td>
                            <strong>{{ $order->customer->name ?? 'Customer' }}</strong><br>
                            <small class="text-muted">{{ $order->customer->email ?? '' }}</small>
                        </td>
                        <td>{{ $order->customer->phone ?? 'N/A' }}</td>
                        <td>
                            <strong class="text-dark">{{ $order->pickup_date->format('M d, Y') }}</strong><br>
                            <small class="text-success">{{ $order->pickup_time_slot }}</small>
                        </td>
                        <td>{{ $order->items->sum('quantity') }} items</td>
                        <td><strong class="text-success">Rs. {{ number_format($order->total_amount, 2) }}</strong></td>
                        <td><span class="badge {{ $order->status_badge }}">{{ $order->status_label }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('farmer.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                Manage & Process
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">No pre-orders match the selected filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $orders->links('pagination::bootstrap-5') }}
</div>
@endsection
