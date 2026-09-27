@extends('layouts.app')

@section('title', 'Select Pickup Slot - MarketLink Checkout')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-success text-decoration-none">Basket</a></li>
            <li class="breadcrumb-item active" aria-current="page">Select Pickup Slot</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-clock-history text-success fs-4"></i>
                    <h4 class="fw-bold mb-0">Select Market Pickup Date & Time</h4>
                </div>

                <!-- Stall Location Reminder -->
                <div class="bg-light p-3 rounded-3 border mb-4">
                    <h6 class="fw-bold text-dark-emphasis mb-1"><i class="bi bi-shop text-success me-1"></i>{{ $farmerProfile->stall_name }}</h6>
                    <small class="text-muted d-block"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $farmerProfile->market->name ?? 'Farmers Market' }} - {{ $farmerProfile->market->address ?? 'Market Location' }}</small>
                    <small class="text-muted d-block"><i class="bi bi-pin-map text-primary me-1"></i>Stall Number: <strong>{{ $farmerProfile->stall_number ?: 'Main Bay' }}</strong></small>
                </div>

                <form action="{{ route('customer.orders.store') }}" method="POST" id="checkoutOrderForm">
                    @csrf
                    
                    <!-- Pickup Date Selection -->
                    <div class="mb-4">
                        <label for="pickupDateSelect" class="form-label fw-bold">1. Choose Pickup Market Day <span class="text-danger">*</span></label>
                        <select name="pickup_date" id="pickupDateSelect" class="form-select form-select-lg @error('pickup_date') is-invalid @enderror" required>
                            <option value="">-- Select Market Pickup Date --</option>
                            @foreach($pickupDates as $pDate)
                                <option value="{{ $pDate['date'] }}" {{ (old('pickup_date') == $pDate['date'] || ($loop->first && !old('pickup_date'))) ? 'selected' : '' }}>
                                    {{ $pDate['label'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('pickup_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted">Farmer operates on: <strong>{{ $farmerProfile->operating_days }}</strong></small>
                    </div>

                    <!-- Time Slot Selection -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label fw-bold mb-0">2. Select Pickup Time Window <span class="text-danger">*</span></label>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" id="slotCounterBadge">{{ count($timeSlots) }} slots available</span>
                        </div>
                        
                        <div class="row g-2" id="timeSlotsContainer">
                            @foreach($timeSlots as $slotData)
                                @php
                                    $slotVal = is_array($slotData) ? $slotData['slot'] : $slotData;
                                    $toHour = is_array($slotData) ? $slotData['to_hour'] : 24;
                                    $toMin = is_array($slotData) ? $slotData['to_minute'] : 0;
                                @endphp
                                <div class="col-sm-6 slot-wrapper" data-to-hour="{{ $toHour }}" data-to-min="{{ $toMin }}">
                                    <input type="radio" 
                                           class="btn-check time-slot-radio" 
                                           name="pickup_time_slot" 
                                           id="slot_{{ $loop->index }}" 
                                           value="{{ $slotVal }}" 
                                           {{ ($loop->first && !old('pickup_time_slot')) || old('pickup_time_slot') == $slotVal ? 'checked' : '' }} 
                                           required>
                                    <label class="slot-option-card d-flex align-items-center justify-content-between p-3 rounded-3 border w-100 {{ (($loop->first && !old('pickup_time_slot')) || old('pickup_time_slot') == $slotVal) ? 'active' : '' }}" 
                                           for="slot_{{ $loop->index }}">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-clock-fill slot-icon text-success"></i>
                                            <span class="slot-title fw-semibold">{{ $slotVal }}</span>
                                        </div>
                                        <div class="slot-status-indicator">
                                            <i class="bi bi-check-circle-fill text-success fs-5 check-icon {{ (($loop->first && !old('pickup_time_slot')) || old('pickup_time_slot') == $slotVal) ? '' : 'd-none' }}"></i>
                                            <i class="bi bi-circle text-muted fs-5 uncheck-icon {{ (($loop->first && !old('pickup_time_slot')) || old('pickup_time_slot') == $slotVal) ? 'd-none' : '' }}"></i>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <!-- Selected Slot Notice Pill -->
                        <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mt-3 mb-0" id="selectedSlotNotice">
                            <i class="bi bi-check2-circle fs-5 text-success"></i>
                            <div>
                                Selected Slot: <strong id="selectedSlotText">{{ old('pickup_time_slot') ?: (is_array($timeSlots[0]) ? $timeSlots[0]['slot'] : $timeSlots[0]) }}</strong>
                            </div>
                        </div>

                        <div id="allSlotsExpiredNotice" class="alert alert-warning py-2 px-3 mt-3 mb-0 d-none">
                            <i class="bi bi-exclamation-triangle-fill me-1 text-warning"></i>
                            All pickup windows for today have closed. Please select the next available market day above.
                        </div>
                    </div>

                    <!-- Customer Notes -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">3. Special Harvest / Packaging Instructions (Optional)</label>
                        <textarea name="customer_notes" class="form-control" rows="3" placeholder="e.g. Please pick slightly raw bananas, or prepare extra paper bags...">{{ old('customer_notes') }}</textarea>
                    </div>

                    <!-- Confirmation Notice -->
                    <div class="alert alert-info border-info-subtle small mb-4">
                        <i class="bi bi-info-circle-fill me-1"></i>
                        <strong>Payment Notice:</strong> No payment is taken online. You will inspect your harvest bag and pay <strong>Rs. {{ number_format($total, 2) }}</strong> directly at the stall.
                    </div>

                    <button type="submit" class="btn btn-market btn-lg w-100 py-3 fw-bold shadow">
                        <i class="bi bi-check2-circle me-2"></i> Confirm & Place Pre-Order
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Items Summary Sidebar -->
        <div class="col-lg-5">
            <div class="card card-custom p-4 border-0 shadow-sm">
                <h5 class="fw-bold mb-3">Pre-Order Items ({{ count($cart) }})</h5>
                <ul class="list-group list-group-flush mb-3">
                    @foreach($cart as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <h6 class="fw-bold mb-0">{{ $item['name'] }}</h6>
                                <small class="text-muted">{{ $item['quantity'] }} x Rs. {{ number_format($item['price'], 0) }} / {{ $item['unit'] }}</small>
                            </div>
                            <span class="fw-bold text-success">Rs. {{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="d-flex justify-content-between pt-3 border-top">
                    <span class="fs-5 fw-bold">Total Amount:</span>
                    <span class="fs-5 fw-bold text-success">Rs. {{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.slot-option-card {
    background-color: #ffffff;
    border: 1.5px solid #e2e8f0 !important;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    color: #334155;
    user-select: none;
}
.slot-option-card:hover {
    border-color: #16a34a !important;
    background-color: #f0fdf4;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(22, 163, 74, 0.08);
}
.slot-option-card.active {
    background-color: #f0fdf4 !important;
    border-color: #16a34a !important;
    color: #15803d !important;
    box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.25) !important;
}
.slot-option-card.disabled {
    background-color: #f8fafc !important;
    border-color: #e2e8f0 !important;
    color: #94a3b8 !important;
    cursor: not-allowed !important;
    opacity: 0.6;
    pointer-events: none;
}
.slot-option-card.disabled .slot-icon {
    color: #cbd5e1 !important;
}
[data-bs-theme="dark"] .slot-option-card {
    background-color: #1e293b;
    border-color: #334155 !important;
    color: #f8fafc;
}
[data-bs-theme="dark"] .slot-option-card:hover {
    background-color: #064e3b;
    border-color: #10b981 !important;
}
[data-bs-theme="dark"] .slot-option-card.active {
    background-color: #064e3b !important;
    border-color: #10b981 !important;
    color: #a7f3d0 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const todayDateStr = "{{ $todayDate ?? now()->format('Y-m-d') }}";
    const currentHour = {{ $currentHour ?? (int)now()->format('H') }};
    const currentMinute = {{ $currentMinute ?? (int)now()->format('i') }};

    const dateSelect = document.getElementById('pickupDateSelect');
    const slotRadios = document.querySelectorAll('.time-slot-radio');
    const slotCards = document.querySelectorAll('.slot-option-card');
    const slotWrappers = document.querySelectorAll('.slot-wrapper');
    const selectedSlotText = document.getElementById('selectedSlotText');
    const selectedSlotNotice = document.getElementById('selectedSlotNotice');
    const allSlotsExpiredNotice = document.getElementById('allSlotsExpiredNotice');
    const slotCounterBadge = document.getElementById('slotCounterBadge');

    function updateActiveState(selectedRadio) {
        slotWrappers.forEach(wrapper => {
            const radio = wrapper.querySelector('.time-slot-radio');
            const card = wrapper.querySelector('.slot-option-card');
            const checkIcon = wrapper.querySelector('.check-icon');
            const uncheckIcon = wrapper.querySelector('.uncheck-icon');

            if (radio === selectedRadio && !radio.disabled) {
                radio.checked = true;
                card.classList.add('active');
                if (checkIcon) checkIcon.classList.remove('d-none');
                if (uncheckIcon) uncheckIcon.classList.add('d-none');
                if (selectedSlotText) selectedSlotText.textContent = radio.value;
                if (selectedSlotNotice) selectedSlotNotice.classList.remove('d-none');
            } else {
                card.classList.remove('active');
                if (checkIcon) checkIcon.classList.add('d-none');
                if (uncheckIcon) uncheckIcon.classList.remove('d-none');
            }
        });
    }

    // Attach click listeners to cards and radios
    slotWrappers.forEach(wrapper => {
        const radio = wrapper.querySelector('.time-slot-radio');
        const card = wrapper.querySelector('.slot-option-card');

        card.addEventListener('click', function(e) {
            if (radio.disabled) return;
            radio.checked = true;
            updateActiveState(radio);
        });

        radio.addEventListener('change', function() {
            if (!this.disabled && this.checked) {
                updateActiveState(this);
            }
        });
    });

    // Check availability based on selected pickup date
    function checkSlotsForDate() {
        const selectedDate = dateSelect.value;
        const isToday = (selectedDate === todayDateStr);
        let availableCount = 0;
        let firstAvailableRadio = null;
        let currentSelectedIsValid = false;

        slotWrappers.forEach(wrapper => {
            const radio = wrapper.querySelector('.time-slot-radio');
            const card = wrapper.querySelector('.slot-option-card');
            const toHour = parseInt(wrapper.getAttribute('data-to-hour') || '24', 10);
            const toMin = parseInt(wrapper.getAttribute('data-to-min') || '0', 10);

            let isExpired = false;
            if (isToday) {
                // If the end time has already passed today
                if (toHour < currentHour || (toHour === currentHour && toMin <= currentMinute)) {
                    isExpired = true;
                }
            }

            if (isExpired) {
                radio.disabled = true;
                card.classList.add('disabled');
                card.classList.remove('active');
            } else {
                radio.disabled = false;
                card.classList.remove('disabled');
                availableCount++;
                if (!firstAvailableRadio) {
                    firstAvailableRadio = radio;
                }
                if (radio.checked) {
                    currentSelectedIsValid = true;
                }
            }
        });

        if (slotCounterBadge) {
            slotCounterBadge.textContent = `${availableCount} slots available`;
        }

        if (availableCount === 0) {
            if (allSlotsExpiredNotice) allSlotsExpiredNotice.classList.remove('d-none');
            if (selectedSlotNotice) selectedSlotNotice.classList.add('d-none');
        } else {
            if (allSlotsExpiredNotice) allSlotsExpiredNotice.classList.add('d-none');
            if (selectedSlotNotice) selectedSlotNotice.classList.remove('d-none');

            if (!currentSelectedIsValid && firstAvailableRadio) {
                firstAvailableRadio.checked = true;
                updateActiveState(firstAvailableRadio);
            } else {
                const checkedRadio = document.querySelector('.time-slot-radio:checked:not(:disabled)');
                if (checkedRadio) {
                    updateActiveState(checkedRadio);
                }
            }
        }
    }

    if (dateSelect) {
        dateSelect.addEventListener('change', checkSlotsForDate);
    }

    // Run on initial load
    checkSlotsForDate();
});
</script>
@endsection
