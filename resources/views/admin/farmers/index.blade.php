@extends('layouts.admin')

@section('title', 'Farmer Verifications & Approvals')
@section('page-title', 'Farmer Registration & Stall Moderation')

@section('content')
<div class="card card-stat border-0 shadow-sm p-3 mb-4">
    <div class="d-flex gap-2">
        <a href="{{ route('admin.farmers.index') }}" class="btn btn-sm {{ empty($status) ? 'btn-success' : 'btn-outline-secondary' }}">All Farmers</a>
        <a href="{{ route('admin.farmers.index', ['status' => 'pending']) }}" class="btn btn-sm {{ $status === 'pending' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }}">
            Pending Approvals
        </a>
        <a href="{{ route('admin.farmers.index', ['status' => 'approved']) }}" class="btn btn-sm {{ $status === 'approved' ? 'btn-success' : 'btn-outline-success' }}">Approved</a>
        <a href="{{ route('admin.farmers.index', ['status' => 'suspended']) }}" class="btn btn-sm {{ $status === 'suspended' ? 'btn-danger' : 'btn-outline-danger' }}">Suspended</a>
    </div>
</div>

<div class="card card-stat border-0 shadow-sm overflow-hidden p-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Stall & Business Name</th>
                    <th>Grower Name</th>
                    <th>Market Assigned</th>
                    <th>Phone / Email</th>
                    <th>Listed Produce</th>
                    <th>Status</th>
                    <th class="text-end">Moderation Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($farmers as $farmer)
                    <tr>
                        <td>
                            <strong>{{ $farmer->stall_name }}</strong><br>
                            <small class="text-muted">{{ Str::limit($farmer->bio, 35) }}</small>
                        </td>
                        <td>
                            <strong>{{ $farmer->user->name ?? 'User' }}</strong><br>
                            <small class="text-muted">Registered {{ $farmer->created_at->format('M d, Y') }}</small>
                        </td>
                        <td>{{ $farmer->market->name ?? 'None' }}</td>
                        <td>
                            <small class="d-block">{{ $farmer->user->phone ?? 'N/A' }}</small>
                            <small class="text-muted">{{ $farmer->user->email ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $farmer->products_count }} items</span>
                        </td>
                        <td>
                            @if($farmer->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($farmer->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending Review</span>
                            @else
                                <span class="badge bg-danger">Suspended</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($farmer->status === 'pending')
                                <form action="{{ route('admin.farmers.approve', $farmer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="bi bi-check-lg me-1"></i> Approve
                                    </button>
                                </form>
                            @elseif($farmer->status === 'approved')
                                <form action="{{ route('admin.farmers.suspend', $farmer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-slash-circle me-1"></i> Suspend
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.farmers.activate', $farmer->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-arrow-repeat me-1"></i> Reactivate
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No farmers found in this status category.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $farmers->links('pagination::bootstrap-5') }}
</div>
@endsection
