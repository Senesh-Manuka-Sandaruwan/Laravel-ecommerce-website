@extends('userLayouts.master-contact')

@section('title', 'Crunchy Sweets Shop')

@section('content')
<div class="container py-5 mt-3" style="color: #5D4037;">
    <div class="row justify-content-center">
        <div class="col-lg-10 text-center mb-4">
            <h1 class="display-3 fw-bold mb-3" style="font-family: 'Lora', serif;">Get in Touch</h1>
            <p class="lead" style="font-size: 1.25rem;">
                We'd love to hear from you! Send us a message and we'll respond as soon as possible.
            </p>
        </div>
    </div>
    <div class="row justify-content-center g-4">
        <!-- Contact Information Card -->
        <div class="col-lg-5">
            <div class="h-100 p-4 p-md-5 border rounded-4 shadow-sm" style="border-color: #5D4037; background: #fff;">
                <h2 class="mb-4 fw-bold" style="font-family: 'Lora', serif;">Contact Information</h2>
                <div class="mb-4 d-flex align-items-start">
                    <span class="me-3 fs-3"><i class="fas fa-map-marker-alt"></i></span>
                    <div>
                        <div class="fw-semibold">Our Location</div>
                        <div>123 Sweet Street, Sugar City, SC 12345</div>
                    </div>
                </div>
                <div class="mb-4 d-flex align-items-start">
                    <span class="me-3 fs-3"><i class="fas fa-phone-alt"></i></span>
                    <div>
                        <div class="fw-semibold">Call Us</div>
                        <div>(123) 456-7890</div>
                    </div>
                </div>
                <div class="mb-4 d-flex align-items-start">
                    <span class="me-3 fs-3"><i class="fas fa-envelope"></i></span>
                    <div>
                        <div class="fw-semibold">Email Us</div>
                        <div>info@crunchysweets.com</div>
                    </div>
                </div>
                <hr class="my-4">
                <h4 class="mb-3 fw-bold" style="font-family: 'Lora', serif;">Business Hours</h4>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-1">
                        <span>Monday - Friday</span>
                        <span>8:00 AM - 8:00 PM</span>
                    </li>
                    <li class="d-flex justify-content-between py-1">
                        <span>Saturday - Sunday</span>
                        <span>9:00 AM - 6:00 PM</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Send Us a Message Card -->
        <div class="col-lg-7">
            <div class="h-100 p-4 p-md-5 border rounded-4 shadow-sm" style="border-color: #5D4037; background: #fff;">
                <h2 class="mb-4 fw-bold" style="font-family: 'Lora', serif;">Send Us a Message</h2>
                <div id="contact-success" class="alert alert-success d-none"
                    style="z-index: 1050;">
                    <i class="fas fa-check-circle me-2"></i>
                    Thank you for your message! We'll get back to you soon.
                </div>
                <form id="contact-form">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Your Name</label>
                        <input type="text" class="form-control rounded-3" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Address</label>
                        <input type="email" class="form-control rounded-3" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label fw-semibold">Subject</label>
                        <input type="text" class="form-control rounded-3" id="subject" required>
                    </div>
                    <div class="mb-4">
                        <label for="message" class="form-label fw-semibold">Message</label>
                        <textarea class="form-control rounded-3" id="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-3 fs-5 rounded-pill">
                        <i class="fas fa-paper-plane me-2"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


@push('styles')
<style>
    .form-control:focus {
        border-color: #FFD54F;
        box-shadow: 0 0 0 0.25rem rgba(255, 213, 79, 0.25);
    }
    .border {
        border-width: 2px !important;
    }
    .rounded-4 {
        border-radius: 1.25rem !important;
    }
    .shadow-sm {
        box-shadow: 0 2px 8px rgba(93, 64, 55, 0.06) !important;
    }
    @media (max-width: 991.98px) {
        .col-lg-5, .col-lg-7 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>
@endpush


@push('scripts')
<script>
    document.getElementById('contact-form').addEventListener('submit', function (e) {
        e.preventDefault();
        document.getElementById('contact-success').classList.remove('d-none');
        this.reset();
        setTimeout(function () {
            document.getElementById('contact-success').classList.add('d-none');
        }, 5000);
    });
</script>
@endpush
@endsection