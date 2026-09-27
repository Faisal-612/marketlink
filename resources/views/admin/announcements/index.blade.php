@extends('layouts.admin')

@section('title', 'Platform Announcements')
@section('page-title', 'Broadcast System Announcements')

@section('content')
<div class="row g-4">
    <!-- Publish Announcement Form -->
    <div class="col-lg-4">
        <div class="card card-stat border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-megaphone-fill text-warning me-1"></i> New Announcement</h5>
            
            <form action="{{ route('admin.announcements.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Announcement Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Weekend Fair Special Guidelines" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Target Audience</label>
                    <select name="target_role" class="form-select">
                        <option value="all">All Platform Users (Public Banner)</option>
                        <option value="farmer">Farmers / Vendors Only</option>
                        <option value="customer">Shoppers / Customers Only</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Content Message <span class="text-danger">*</span></label>
                    <textarea name="content" class="form-control" rows="4" placeholder="Write the announcement details..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary-app w-100">
                    <i class="fi fi-rr-megaphone me-1"></i> Broadcast Announcement
                </button>
            </form>
        </div>
    </div>

    <!-- Active Announcements List -->
    <div class="col-lg-8">
        <div class="card card-stat border-0 shadow-sm p-4">
            <h5 class="fw-bold mb-3">Published Announcements</h5>
            <div class="row g-3">
                @forelse($announcements as $ann)
                    <div class="col-12">
                        <div class="card border p-3 rounded-3 shadow-none">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $ann->title }}</h6>
                                    <small class="text-muted">Target: <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($ann->target_role) }}</span> | {{ $ann->created_at->format('M d, Y h:i A') }}</small>
                                </div>
                                <form action="{{ route('admin.announcements.destroy', $ann->id) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Announcement">
                                        <i class="fi fi-rr-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                            <p class="text-muted mb-0 small">{{ $ann->content }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-4">No active announcements broadcasted.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
