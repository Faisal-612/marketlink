@extends('layouts.admin')

@section('title', 'Platform Reports & Analytics')
@section('page-title', 'Revenue Reports & Platform Analytics')

@section('content')
<!-- Date Filter Bar -->
<div class="card card-stat border-0 shadow-sm p-3 mb-4">
    <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-4">
            <label class="form-label small fw-semibold">Start Date</label>
            <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
        </div>
        <div class="col-md-4">
            <label class="form-label small fw-semibold">End Date</label>
            <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
        </div>
        <div class="col-md-4 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-sm btn-success flex-grow-1"><i class="bi bi-funnel me-1"></i> Filter Period</button>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>

<!-- Summary Badges -->
<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card card-stat border-0 shadow-sm">
            <small class="text-muted fw-semibold text-uppercase">Total Period Orders</small>
            <h3 class="fw-bold text-dark mt-1 mb-0">{{ $totalPeriodOrders }}</h3>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-stat border-0 shadow-sm">
            <small class="text-muted fw-semibold text-uppercase">Total Period Gross Volume</small>
            <h3 class="fw-bold text-success mt-1 mb-0">Rs. {{ number_format($totalPeriodRevenue, 2) }}</h3>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Chart: Revenue by Market -->
    <div class="col-lg-6">
        <div class="card card-stat border-0 shadow-sm p-4 h-100">
            <h5 class="fw-bold mb-3"><i class="bi bi-bar-chart-fill text-success me-2"></i>Revenue by Weekend Market</h5>
            <canvas id="marketChart" style="max-height: 280px;"></canvas>
        </div>
    </div>

    <!-- Chart: Order Status Breakdown -->
    <div class="col-lg-6">
        <div class="card card-stat border-0 shadow-sm p-4 h-100">
            <h5 class="fw-bold mb-3"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Orders Status Distribution</h5>
            <canvas id="statusChart" style="max-height: 280px;"></canvas>
        </div>
    </div>
</div>

<!-- Breakdown Tables -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card card-stat border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-3">Revenue Breakdown by Market</h5>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Market Name</th>
                            <th>City</th>
                            <th>Total Orders</th>
                            <th class="text-end">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($revenueByMarket as $rm)
                            <tr>
                                <td><strong>{{ $rm->market_name }}</strong></td>
                                <td>{{ $rm->city }}</td>
                                <td>{{ $rm->total_orders }}</td>
                                <td class="text-end fw-bold text-success">Rs. {{ number_format($rm->total_revenue, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card card-stat border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-3">Most Active Farmers by Volume</h5>
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Farm Stall</th>
                            <th>Grower</th>
                            <th>Orders</th>
                            <th class="text-end">Gross Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topFarmers as $tf)
                            <tr>
                                <td><strong>{{ $tf->stall_name }}</strong></td>
                                <td>{{ $tf->farmer_name }}</td>
                                <td>{{ $tf->orders_count }}</td>
                                <td class="text-end fw-bold text-success">Rs. {{ number_format($tf->revenue, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Market Revenue Chart
        const marketLabels = {!! json_encode($revenueByMarket->pluck('market_name')) !!};
        const marketValues = {!! json_encode($revenueByMarket->pluck('total_revenue')) !!};

        new Chart(document.getElementById('marketChart'), {
            type: 'bar',
            data: {
                labels: marketLabels,
                datasets: [{
                    label: 'Gross Sales (PKR)',
                    data: marketValues,
                    backgroundColor: '#2d6a4f',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });

        // Status Breakdown Chart
        const statusLabels = {!! json_encode($ordersByStatus->pluck('order_status')->map(fn($s) => ucfirst($s))) !!};
        const statusCounts = {!! json_encode($ordersByStatus->pluck('count')) !!};

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusCounts,
                    backgroundColor: ['#e9c46a', '#52b788', '#2a9d8f', '#264653', '#e76f51']
                }]
            },
            options: {
                responsive: true
            }
        });
    });
</script>
@endsection
