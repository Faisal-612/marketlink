@extends('layouts.admin')

@section('title', 'Customers Management')
@section('page-title', 'Customer Accounts & Access Management')

@section('content')
<div class="card card-stat border-0 shadow-sm p-3 mb-4">
    <form action="{{ route('admin.customers.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search customer name or email..." value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select form-select-sm">
                <option value="">-- All Statuses --</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-success flex-grow-1">Search</button>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

<div class="card card-stat border-0 shadow-sm overflow-hidden p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Customer</th>
                    <th>Email Address</th>
                    <th>Contact Phone</th>
                    <th>Address</th>
                    <th>Total Orders</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $cust)
                    <tr>
                        <td>
                            <strong>{{ $cust->name }}</strong><br>
                            <small class="text-muted">Joined {{ $cust->created_at->format('M d, Y') }}</small>
                        </td>
                        <td>{{ $cust->email }}</td>
                        <td>{{ $cust->phone ?? 'N/A' }}</td>
                        <td><small>{{ Str::limit($cust->address, 30) }}</small></td>
                        <td><span class="badge bg-light text-dark border">{{ $cust->customer_orders_count }} orders</span></td>
                        <td>
                            <span class="badge {{ $cust->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                {{ ucfirst($cust->status) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <form action="{{ route('admin.customers.toggle_status', $cust->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $cust->status === 'active' ? 'btn-outline-danger' : 'btn-outline-success' }}">
                                    {{ $cust->status === 'active' ? 'Suspend Account' : 'Reactivate Account' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No customers found matching search criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $customers->links('pagination::bootstrap-5') }}
</div>
@endsection
