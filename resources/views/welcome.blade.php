<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/png" style="border-radius: 50%;">
    <title>Crunchy Sweets | Premium Sweet Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
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

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-color);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Lora', serif;
            color: var(--dark-color);
        }

        .hero-section {
            background: linear-gradient(rgba(255, 236, 179, 0.2), rgba(255, 236, 179, 0.3));
            padding: 120px 0 80px;
        }

        .navbar {
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: var(--primary-light) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .category-icon {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--dark-color);
            font-size: 2.5rem;
            transition: transform 0.3s ease;
        }

        .category-icon:hover {
            transform: scale(1.1);
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
        }

        .category-item {
            text-align: center;
            padding: 20px 10px;
        }

        .category-item h5 {
            margin-top: 15px;
            color: var(--dark-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: black;
            color: var(--dark-color);
        }

        .btn-primary:hover {
            background-color: var(--dark-color);
            border-color: var(--primary-light);
            color: white;
        }

        .btn-primary:active {
            background-color: var(--dark-color) !important;
            border-color: var(--primary-light) !important;
            color: white !important;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-dark);
            color: white;
        }

        .btn-secondary:hover {
            background-color: var(--secondary-dark);
            border-color: var(--secondary-dark);
            color: white;
        }

        .categories-section {
            overflow-x: auto;
            white-space: nowrap;
            padding: 20px 0;
        }

        .categories-container {
            display: inline-flex;
            gap: 30px;
            padding: 0 20px;
        }

        .bg-light {
            background-color: var(--primary-light) !important;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .position-absolute.bg-danger {
            background-color: var(--secondary-color) !important;
        }

        footer {
            background-color: var(--dark-color) !important;
        }

        @media (min-width: 992px) {
            .categories-container {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 50px;
            }
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });
    </script>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top bg-transparent">
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
                        <a class="nav-link" href="#home" style="color: var(--dark-color);"
                            onmouseover="highlightLink(this)" onmouseout="removeHighlight(this)"
                            onclick="scrollToSection(event, 'home')">Home</a>
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
                        <a class="btn btn-primary ms-lg-3" href="{{ route('login') }}">Login</a>
                    </li>
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

    <!-- Hero Section -->
    <section id="home" class="hero-section" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h1 class="display-4 mb-4">Delicious Sweets for Every Occasion</h1>
                    <p class="lead mb-4">Handcrafted with love using the finest ingredients. Our sweets make every
                        moment special.</p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg" data-aos="zoom-in">Order Now</a>
                        <a href="#offers" class="btn btn-primary btn-lg" data-aos="zoom-in">View Offers</a>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1 text-center mt-5 mt-lg-0" data-aos="fade-left">
                    <img src="https://images.pexels.com/photos/1721932/pexels-photo-1721932.jpeg" alt="Featured Sweets"
                        class="img-fluid rounded-circle shadow"
                        style="width: 100%; height: auto; aspect-ratio: 1 / 1; object-fit: cover; margin-top: 20px; border: 5px solid var(--primary-color);">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories -->
    <section id="categories" class="py-5" data-aos="fade-up">
        <div class="container">
            <h2 class="text-center mb-5">Our Sweet Categories</h2>
            <div class="categories-section">
                <div class="categories-container">
                    <div class="category-item" data-aos="zoom-in">
                        <div class="category-icon">
                            <i class="bi bi-cake"></i>
                        </div>
                        <h5>Chocolates</h5>
                    </div>
                    <div class="category-item" data-aos="zoom-in">
                        <div class="category-icon">
                            <i class="bi bi-cup-straw"></i>
                        </div>
                        <h5>Lollipops</h5>
                    </div>
                    <div class="category-item" data-aos="zoom-in">
                        <div class="category-icon">
                            <i class="bi bi-balloon"></i>
                        </div>
                        <h5>Gummy Bears</h5>
                    </div>
                    <div class="category-item" data-aos="zoom-in">
                        <div class="category-icon">
                            <i class="bi bi-gift"></i>
                        </div>
                        <h5>Jelly Beans</h5>
                    </div>
                    <div class="category-item" data-aos="zoom-in">
                        <div class="category-icon">
                            <i class="bi bi-heart"></i>
                        </div>
                        <h5>Marshmallows</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Special Offers -->
    <section id="offers" class="py-5 bg-light" data-aos="fade-up">
        <div class="container">
            <h2 class="text-center mb-5">Special Offers</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="flip-left">
                    <div class="card h-100">
                        <div class="position-relative">
                            <img src="https://images.pexels.com/photos/461431/pexels-photo-461431.jpeg"
                                class="card-img-top" alt="Special Offer">
                            <div class="position-absolute top-0 end-0 bg-danger text-white px-3 py-2">20% OFF</div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Birthday Special</h5>
                            <p class="card-text">Get 20% off on all birthday cakes this month!</p>
                            <a href="#" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="flip-left">
                    <div class="card h-100">
                        <div class="position-relative">
                            <img src="https://images.pexels.com/photos/1028714/pexels-photo-1028714.jpeg"
                                class="card-img-top" alt="Cupcake Deal">
                            <div class="position-absolute top-0 end-0 bg-danger text-white px-3 py-2">Buy 6 Get 2</div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Cupcake Bundle</h5>
                            <p class="card-text">Buy 6 cupcakes and get 2 free!</p>
                            <a href="#" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="flip-left">
                    <div class="card h-100">
                        <div class="position-relative">
                            <img src="https://images.pexels.com/photos/1702373/pexels-photo-1702373.jpeg"
                                class="card-img-top" alt="Wedding Cake">
                            <div class="position-absolute top-0 end-0 bg-danger text-white px-3 py-2">Free Tasting</div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Wedding Consultation</h5>
                            <p class="card-text">Free cake tasting for wedding consultations!</p>
                            <a href="#" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 text-white">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });
    </script>
</body>

</html>