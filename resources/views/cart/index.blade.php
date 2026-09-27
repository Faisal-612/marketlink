@extends('layouts.app')

@section('title', 'Pre-Order Basket - MarketLink')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pre-Order Basket</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-4"><i class="fi fi-rr-shopping-cart text-success me-2"></i>My Pre-Order Basket</h2>

    @if(count($cart) > 0)
        @php $firstItem = reset($cart); @endphp
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Farmer Stall Notice -->
                <div class="alert alert-success border-success-subtle d-flex align-items-center gap-2 mb-3">
                    <i class="fi fi-rr-shop fs-5"></i>
                    <div>
                        Pre-order for <strong>{{ $firstItem['stall_name'] }}</strong> at <em>{{ $firstItem['market_name'] }}</em>
                    </div>
                </div>

                <div class="card card-custom p-4 border-0 shadow-sm">
                    <form action="{{ route('cart.update') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produce Item</th>
                                        <th>Price</th>
                                        <th style="width: 130px;">Quantity</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart as $id => $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{ $item['image'] ?: asset('images/products/item_101.jpg') }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $item['name'] }}">
                                                    <div>
                                                        <h6 class="fw-bold mb-0">{{ $item['name'] }}</h6>
                                                        <small class="text-muted">Unit: {{ $item['unit'] }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Rs. {{ number_format($item['price'], 2) }}</td>
                                            <td>
                                                <input type="number" name="quantities[{{ $id }}]" class="form-control form-control-sm" value="{{ $item['quantity'] }}" min="1">
                                            </td>
                                            <td class="fw-bold text-success">
                                                Rs. {{ number_format($item['price'] * $item['quantity'], 2) }}
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm text-danger" title="Remove" onclick="removeCartItemAjax({{ $id }}, this)">
                                                    <i class="fi fi-rr-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fi fi-rr-arrow-left me-1"></i> Continue Shopping
                            </a>
                            <button type="submit" class="btn btn-outline-success btn-sm">
                                <i class="fi fi-rr-refresh me-1"></i> Update Quantities
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Pre-Order Summary Box -->
            <div class="col-lg-4">
                <div class="card card-custom p-4 border-0 shadow-sm">
                    <h5 class="fw-bold mb-3">Pre-Order Summary</h5>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Items:</span>
                        <span class="fw-semibold" id="summaryTotalItems">{{ array_sum(array_column($cart, 'quantity')) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal:</span>
                        <span class="fw-semibold" id="summarySubtotal">Rs. {{ number_format($total, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Advance Payment:</span>
                        <span class="badge bg-success-subtle text-success">Rs. 0 (Pay at Pickup)</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="fw-bold mb-0">Total Due at Pickup:</h5>
                        <h5 class="fw-bold text-success mb-0" id="summaryTotalDue">Rs. {{ number_format($total, 2) }}</h5>
                    </div>

                    @auth
                        @if(Auth::user()->isCustomer())
                            <a href="{{ route('customer.checkout') }}" class="btn btn-market w-100 py-2 fw-semibold">
                                Proceed to Select Pickup Slot <i class="fi fi-rr-arrow-right ms-1"></i>
                            </a>
                        @else
                            <div class="alert alert-warning small mb-0">
                                You are logged in as <strong>{{ Auth::user()->role }}</strong>. Please log in with a customer account to place pre-orders.
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-market w-100 py-2 fw-semibold">
                            Sign In to Pre-Order
                        </a>
                        <small class="text-muted d-block text-center mt-2">New customer? <a href="{{ route('register') }}" class="text-success">Register here</a></small>
                    @endauth
                </div>
            </div>
        </div>
    @else
        <div class="card card-custom p-5 border-0 shadow-sm text-center">
            <i class="fi fi-rr-shopping-cart text-muted" style="font-size: 4rem;"></i>
            <h4 class="fw-bold mt-3">Your Pre-Order Basket is Empty</h4>
            <p class="text-muted mb-4">Explore fresh organic harvest from verified local farmers and add them to your pre-order basket.</p>
            <div>
                <a href="{{ route('products.index') }}" class="btn btn-market px-4 py-2">
                    <i class="fi fi-rr-apps me-1"></i> Browse Fresh Produce
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function removeCartItemAjax(productId, btn) {
    const row = btn.closest('tr');
    btn.disabled = true;
    
    fetch(`{{ url('/cart/remove') }}/${productId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            updateCartBadge(data.cartCount);
            if (data.isEmpty) {
                window.location.reload();
            } else {
                row.remove();
                document.getElementById('summaryTotalItems').innerText = data.cartCount;
                document.getElementById('summarySubtotal').innerText = 'Rs. ' + data.totalPrice;
                document.getElementById('summaryTotalDue').innerText = 'Rs. ' + data.totalPrice;
                showToast('Item removed from basket', 'success');
            }
        }
    });
}
</script>
@endsection
