
@extends('userLayouts.master-without-nav')

@section('title', 'About Us - Crunchy Sweets')

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
                        <a class="nav-link" href="{{ route('welcome') }}" style="color: var(--dark-color);" onmouseover="highlightLink(this)"
                            onmouseout="removeHighlight(this)">Home</a>
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
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <h1 class="display-4 mb-4">Our Sweet Story</h1>
                <p class="lead mb-4">Founded in 2010, Crunchy Sweets began as a small family-owned bakery with a passion for
                    creating delicious, handcrafted sweets.</p>

                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary-color p-3 rounded-circle me-4">
                        <i class="fas fa-heart text-white fs-4"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Made with Love</h4>
                        <p class="mb-0">Every sweet is crafted with care using family recipes passed down through
                            generations.</p>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary-color p-3 rounded-circle me-4">
                        <i class="fas fa-leaf text-white fs-4"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Quality Ingredients</h4>
                        <p class="mb-0">We source only the finest natural ingredients for all our products.</p>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="bg-primary-color p-3 rounded-circle me-4">
                        <i class="fas fa-award text-white fs-4"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Award Winning</h4>
                        <p class="mb-0">Recognized as "Best Local Sweet Shop" for 5 consecutive years.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <img src="https://images.pexels.com/photos/1070945/pexels-photo-1070945.jpeg" alt="Our Bakery"
                    class="img-fluid rounded-lg shadow-lg" style="border: 5px solid var(--primary-color);">
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
@endsection

@push('styles')
    <style>
        .navbar {
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endpush