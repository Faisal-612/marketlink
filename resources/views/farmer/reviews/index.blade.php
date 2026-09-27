@extends('layouts.farmer')

@section('title', 'Customer Reviews & Ratings')
@section('page-title', 'Customer Reviews & Feedback')

@section('content')
<!-- Reviews Analytics Stats Bar -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 border-0 shadow-sm text-center">
            <small class="text-muted fw-semibold d-block mb-1">Average Rating</small>
            <div class="d-flex align-items-center justify-content-center gap-1 text-warning fs-4 fw-bold">
                <i class="bi bi-star-fill"></i>
                <span class="text-dark">{{ $avgRating > 0 ? number_format($avgRating, 1) : 'N/A' }}</span>
                <small class="text-muted fs-6 fw-normal">/ 5.0</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 border-0 shadow-sm text-center">
            <small class="text-muted fw-semibold d-block mb-1">Total Reviews</small>
            <div class="fs-4 fw-bold text-success">{{ $totalReviews }}</div>
            <small class="text-muted" style="font-size: 0.75rem;">Received from customers</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 border-0 shadow-sm text-center">
            <small class="text-muted fw-semibold d-block mb-1">5-Star Feedback</small>
            <div class="fs-4 fw-bold text-primary">{{ $fiveStarCount }}</div>
            <small class="text-muted" style="font-size: 0.75rem;">Top rated experiences</small>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 border-0 shadow-sm text-center">
            <small class="text-muted fw-semibold d-block mb-1">Pending Replies</small>
            <div class="fs-4 fw-bold {{ $pendingReplies > 0 ? 'text-danger' : 'text-secondary' }}">{{ $pendingReplies }}</div>
            <small class="text-muted" style="font-size: 0.75rem;">Awaiting your response</small>
        </div>
    </div>
</div>

<!-- Reviews List -->
<div class="row g-4">
    @forelse($reviews as $review)
        <div class="col-lg-6">
            <div class="card card-custom border-0 shadow-sm p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px;">
                            {{ strtoupper(substr($review->customer->name ?? 'C', 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ $review->customer->name ?? 'Verified Shopper' }}</h6>
                            <small class="text-muted" style="font-size: 0.78rem;">
                                {{ $review->created_at->format('M d, Y • h:i A') }}
                                @if($review->order)
                                    &bull; Order <a href="{{ route('farmer.orders.show', $review->order_id) }}" class="text-success text-decoration-none fw-semibold">#{{ $review->order->order_number }}</a>
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </div>
                </div>

                @if($review->product)
                    <div class="mb-2">
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-tag-fill text-success me-1"></i> {{ $review->product->name }}
                        </span>
                    </div>
                @endif

                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <p class="mb-0 text-dark fst-italic" style="font-size: 0.92rem;">
                        &ldquo;{{ $review->comment }}&rdquo;
                    </p>
                </div>

                @if($review->farmer_reply)
                    <div class="bg-success-subtle p-3 rounded-3 mt-auto border border-success-subtle small">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <strong class="text-success"><i class="bi bi-reply-fill me-1"></i>Your Stall Reply:</strong>
                            <small class="text-muted">{{ $review->replied_at ? $review->replied_at->format('M d, Y') : '' }}</small>
                        </div>
                        <p class="mb-0 text-dark">{{ $review->farmer_reply }}</p>
                    </div>
                @else
                    <form action="{{ route('farmer.reviews.reply', $review->id) }}" method="POST" class="mt-auto pt-3 border-top">
                        @csrf
                        <label class="form-label small fw-semibold text-muted mb-1">Reply to this customer</label>
                        <div class="input-group">
                            <input type="text" name="farmer_reply" class="form-control form-control-sm" placeholder="Write a thank you or response..." required>
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-send me-1"></i> Send Reply
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card card-custom border-0 shadow-sm text-center py-5 px-3">
                <div class="bg-success-subtle text-success rounded-circle d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px;">
                    <i class="bi bi-chat-heart fs-1"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">No Customer Reviews Yet</h5>
                <p class="text-muted mx-auto" style="max-width: 480px; font-size: 0.92rem;">
                    When shoppers complete their pre-orders or purchase fresh harvest items from your stall, their ratings, comments, and feedback will automatically appear here.
                </p>
                <div class="mt-2">
                    <span class="badge bg-light text-secondary border px-3 py-2">
                        <i class="bi bi-info-circle me-1 text-primary"></i> Real-time database sync active
                    </span>
                </div>
            </div>
        </div>
    @endforelse
</div>

@if($reviews->hasPages())
    <div class="mt-4">
        {{ $reviews->links('pagination::bootstrap-5') }}
    </div>
@endif
@endsection
