@extends('layouts.app')

@section('title', 'Contact Support - MarketLink')

@section('content')
<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Contact Support</li>
        </ol>
    </nav>

    <div class="row g-5">
        <div class="col-lg-5">
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold mb-2">Get In Touch</span>
            <h2 class="fw-bold mb-3">We’re Here to Help</h2>
            <p class="text-secondary mb-4">
                Have questions regarding farmers market schedules, stall registrations, or weekend pre-order pickups? Reach out to our community coordination team.
            </p>

            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                    <i class="fi fi-sr-marker fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-dark">Karachi Coordination Hub</h6>
                    <p class="text-secondary small mb-0">Main Shahrah-e-Faisal, Karachi, Pakistan</p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                    <i class="fi fi-sr-envelope fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-dark">Email Inquiries</h6>
                    <p class="text-secondary small mb-0">support@marketlink.com</p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
                    <i class="fi fi-sr-phone-call fs-5"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-dark">Helpline & WhatsApp Support</h6>
                    <p class="text-secondary small mb-0">+92 300 1234567 (Mon - Sun, 8 AM - 6 PM)</p>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card card-app p-4 p-md-5 border shadow-sm">
                <h4 class="fw-bold mb-4 text-dark">Send Us a Message</h4>
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary small">Your Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Ali Khan" required value="{{ Auth::user()->name ?? '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary small">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="ali.khan@gmail.com" required value="{{ Auth::user()->email ?? '' }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary small">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Market stall inquiry or pickup question..." required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary small">Your Message</label>
                            <textarea name="message" class="form-control" rows="5" placeholder="Write your question or feedback..." required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary-app w-100 py-2">
                                <i class="fi fi-rr-paper-plane me-2"></i> Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
