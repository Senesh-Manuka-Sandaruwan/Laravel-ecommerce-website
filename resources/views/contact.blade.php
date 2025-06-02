@extends('userLayouts.master-without-nav')

@section('title', 'Contact Us - Crunchy Sweets')

@section('content')
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm" style="background-color: #FFF8E1;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/" style="color: var(--dark-color);">
                <img src="{{ asset('assets/img/favicon.png') }}" alt="Crunchy Sweets Logo" class="me-2"
                    style="height: 30px; width: 30px; border-radius: 50%;">
                Crunchy Sweets
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('welcome') }}" style="color: var(--dark-color);"
                            onmouseover="highlightLink(this)" onmouseout="removeHighlight(this)">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}" style="color: var(--dark-color);"
                            onmouseover="highlightLink(this)" onmouseout="removeHighlight(this)">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}" style="color: var(--dark-color);"
                            onmouseover="highlightLink(this)" onmouseout="removeHighlight(this)">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-lg-3" href="{{ route('login') }}"
                            style="background-color: var(--primary-color); border-color: black; color: var(--dark-color);"
                            onmouseover="this.style.backgroundColor='var(--dark-color)'; this.style.color='white';"
                            onmouseout="this.style.backgroundColor='var(--primary-color)'; this.style.color='var(--dark-color)';">
                            Login
                        </a>
                    </li>

                    @push('styles')
                        <style>
                            :root {
                                --primary-color: #FFECB3;
                                /* RGB(255, 236, 179) */
                                --primary-dark: #FFD54F;
                                --primary-dark-2: #FFC107;
                                --primary-light: #FFF8E1;
                                --secondary-color: #D81B60;
                                --secondary-dark: #880E4F;
                                --accent-color: #7CB342;
                                --dark-color: #5D4037;
                                --light-color: #F5F5F5;
                            }

                            .btn-primary {
                                background-color: var(--primary-color);
                                border-color: black;
                                color: var(--dark-color);
                                transition: all 0.3s ease;
                            }

                            .btn-primary:hover {
                                background-color: var(--dark-color);
                                border-color: var(--primary-light);
                                color: white;
                            }
                        </style>
                    @endpush
                </ul>
                <script>
                    function scrollToSection(event, sectionId) {
                        event.preventDefault();
                        const section = document.getElementById(sectionId);
                        const offset = document.querySelector('.navbar').offsetHeight;
                        const topPosition = section.offsetTop - offset;
                        window.scrollTo({ top: topPosition, behavior: 'smooth' });
                    }

                    function highlightLink(link) {
                        link.style.textDecoration = 'underline';
                        link.style.color = 'black';
                    }

                    function removeHighlight(link) {
                        link.style.textDecoration = 'none';
                        link.style.color = 'var(--dark-color)';
                    }
                </script>
            </div>
        </div>
    </nav>

    <div class="container py-5 mt-5" style="color: #5D4037;">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-5">
                <h1 class="display-4 mb-3">Get in Touch</h1>
                <p class="lead">We'd love to hear from you! Send us a message and we'll respond as soon as possible.</p>
            </div>
        </div>

        <div class="row" style="color: #5D4037;">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card shadow-sm h-100" style="border: 1px solid #5D4037;">
                    <div class="card-body p-5">
                        <h3 class="mb-4">Contact Information</h3>

                        <div class="d-flex mb-4">
                            <div class="bg-primary-light p-3 rounded-circle me-4">
                                <i class="fas fa-map-marker-alt text-primary-dark"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Our Location</h5>
                                <p class="mb-0">123 Sweet Street, Sugar City, SC 12345</p>
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <div class="bg-primary-light p-3 rounded-circle me-4">
                                <i class="fas fa-phone-alt text-primary-dark"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Call Us</h5>
                                <p class="mb-0">(123) 456-7890</p>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="bg-primary-light p-3 rounded-circle me-4">
                                <i class="fas fa-envelope text-primary-dark"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Email Us</h5>
                                <p class="mb-0">info@crunchysweets.com</p>
                            </div>
                        </div>

                        <hr class="my-5">

                        <h3 class="mb-4">Business Hours</h3>
                        <ul class="list-unstyled">
                            <li class="d-flex justify-content-between py-2">
                                <span>Monday - Friday</span>
                                <span>8:00 AM - 8:00 PM</span>
                            </li>
                            <li class="d-flex justify-content-between py-2">
                                <span>Saturday - Sunday</span>
                                <span>9:00 AM - 6:00 PM</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm h-100" style="border: 1px solid #5D4037;">
                    <div class="card-body p-5">
                        <h3 class="mb-4">Send Us a Message</h3>

                        <div id="contact-success" class="alert alert-success d-none position-fixed top-0 end-0 mt-3 me-3"
                            style="z-index: 1050;">
                            <i class="fas fa-check-circle me-2"></i>
                            Thank you for your message! We'll get back to you soon.
                        </div>

                        <form id="contact-form">
                            <div class="mb-4">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="name" required
                                    onfocus="this.style.borderColor='#FFD54F'; this.style.boxShadow='0 0 0 0.25rem rgba(255, 213, 79, 0.25)';"
                                    onblur="this.style.borderColor=''; this.style.boxShadow='';">
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" required
                                    onfocus="this.style.borderColor='#FFD54F'; this.style.boxShadow='0 0 0 0.25rem rgba(255, 213, 79, 0.25)';"
                                    onblur="this.style.borderColor=''; this.style.boxShadow='';">
                            </div>

                            <div class="mb-4">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" required
                                    onfocus="this.style.borderColor='#FFD54F'; this.style.boxShadow='0 0 0 0.25rem rgba(255, 213, 79, 0.25)';"
                                    onblur="this.style.borderColor=''; this.style.boxShadow='';">
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="5" required
                                    onfocus="this.style.borderColor='#FFD54F'; this.style.boxShadow='0 0 0 0.25rem rgba(255, 213, 79, 0.25)';"
                                    onblur="this.style.borderColor=''; this.style.boxShadow='';"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-paper-plane me-2"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="py-5 text-white" style="background-color: #5D4037;">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5>Crunchy Sweets</h5>
                    <p>Making your special moments sweeter since 2010.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-twitter"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h5>Contact Us</h5>
                    <address>
                        123 Sweet Street<br>
                        Sugar City, SC 12345<br>
                        <a href="tel:+1234567890" class="text-white">Phone: (123) 456-7890</a><br>
                        <a href="mailto:info@sweetdelights.com" class="text-white">Email: info@sweetdelights.com</a>
                    </address>
                </div>
                <div class="col-lg-4">
                    <h5>Opening Hours</h5>
                    <p>Monday - Friday: 8:00 AM - 8:00 PM<br>
                        Saturday - Sunday: 9:00 AM - 6:00 PM</p>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Crunchy Sweets. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @push('scripts')
        <script>
            document.getElementById('contact-form').addEventListener('submit', function (e) {
                e.preventDefault();

                // Show success message
                document.getElementById('contact-success').classList.remove('d-none');

                // Reset form
                this.reset();

                // Hide success message after 5 seconds
                setTimeout(function () {
                    document.getElementById('contact-success').classList.add('d-none');
                }, 5000);
            });
        </script>
    @endpush
@endsection