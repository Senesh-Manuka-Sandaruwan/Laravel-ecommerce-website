<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/png" style="border-radius: 50%;">
    <title>Crunchy Sweets | @yield('title')</title>

    <!-- Fonts & Icons -->
    <link
        href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'lora': ['Lora', 'serif'],
                    },
                    colors: {
                        'primary': {
                            'DEFAULT': '#FFECB3',
                            'dark': '#FFD54F',
                            'light': '#FFF8E1'
                        },
                        'secondary': {
                            'DEFAULT': '#D81B60',
                            'dark': '#880E4F'
                        },
                        'accent': '#7CB342',
                        'dark': '#5D4037',
                        'light': '#F5F5F5'
                    },
                    transitionProperty: {
                        'width': 'width',
                        'transform': 'transform',
                    }
                }
            }
        }
    </script>

    <!-- Custom Styles -->
    <style type="text/tailwindcss">
        @layer components {
            body {
                background-color: var(--primary-light);
                background-image: url("data:image/svg+xml,%3Csvg width='52' height='26' viewBox='0 0 52 26' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%235D4037' fill-opacity='0.1'%3E%3Cpath d='M10 10c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6h2c0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6 0 2.21 1.79 4 4 4 3.314 0 6 2.686 6 6h-2c0-2.21-1.79-4-4-4-3.314 0-6-2.686-6-6zm25.464-1.95l8.486 8.486-1.414 1.414-8.486-8.486 1.414-1.414z' /%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }
            .btn-primary {
                @apply bg-primary border-dark text-dark hover:bg-dark hover:border-dark hover:text-white transition-all duration-300 border-2;
            }
            .btn-primary:hover {
                @apply transform -translate-y-0.5 shadow-lg shadow-dark/40;
            }
            .btn-secondary {
                @apply bg-secondary border-secondary-dark text-white hover:bg-secondary-dark hover:border-secondary-dark transition-all duration-300;
            }
            .text-primary {
                @apply text-dark;
            }
            .text-primary:hover {
                @apply text-secondary;
            }
            .card {
                @apply transition-all duration-300;
            }
            .card:hover {
                @apply transform -translate-y-1 shadow-xl;
            }
            .form-input:focus {
                @apply border-primary-dark ring-1 ring-primary-dark;
            }
            .side-cart {
                @apply fixed top-0 right-0 h-full w-96 bg-white shadow-lg transform transition-transform duration-300 ease-in-out z-50;
            }
            .side-cart.closed {
                @apply translate-x-full;
            }
            .side-cart.open {
                @apply translate-x-0;
            }
            .cart-overlay {
                @apply fixed inset-0 bg-black bg-opacity-50 z-40 transition-opacity duration-300;
            }
            .cart-overlay.closed {
                @apply opacity-0 pointer-events-none;
            }
            .cart-overlay.open {
                @apply opacity-100;
            }
            .bg-gradient-primary {
                @apply bg-gradient-to-r from-primary to-primary-dark;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="font-poppins">
    <!-- Navigation -->
    <nav class="bg-primary-light shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <a href="{{ route('user.home') }}" class="flex items-center">
                    <img src="{{ asset('assets/img/favicon.jpg') }}" alt="Crunchy Sweets Logo"
                        class="h-10 w-10 mr-2 rounded-full">
                    <span class="text-xl font-lora text-dark">Crunchy Sweets</span>
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('user.home') }}"
                    class="text-dark hover:text-black transition-colors duration-300">Home</a>
                <a class="text-dark hover:text-black transition-colors duration-300" href="{{ route('about-us') }}"
                    onmouseover="highlightLink(this)" onmouseout="removeHighlight(this)">About Us</a>
                <a class="text-dark hover:text-black transition-colors duration-300" href="{{ route('contact-us') }}" href="{{ route('contact-us') }}"
                    onmouseover="highlightLink(this)" onmouseout="removeHighlight(this)">Contact Us</a>

                <!-- Cart Icon with Counter -->
                <button id="cart-toggle" class="relative text-dark hover:text-black transition-colors duration-300">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    <span id="cart-count"
                        class="absolute -top-2 -right-2 bg-secondary text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        {{ $cartCount ?? 0 }}
                    </span>
                </button>

                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="text-dark hover:text-black transition-colors duration-300">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>

            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-dark focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white py-2 px-4 shadow-md">
            <a href="{{ route('user.home') }}"
                class="block py-2 text-dark hover:text-black transition-colors duration-300">Home</a>
            <a href="{{ route('about') }}"
                onclick="document.getElementById('about').scrollIntoView({ behavior: 'smooth' });"
                class="block py-2 text-dark hover:text-black transition-colors duration-300">About Us</a>
            <a href="{{ route('contact') }}"
                onclick="document.getElementById('contact').scrollIntoView({ behavior: 'smooth' });"
                class="block py-2 text-dark hover:text-black transition-colors duration-300">Contact Us</a>

            <button id="mobile-cart-toggle" class="block py-2 text-dark hover:text-black w-full text-left">
                <i class="fas fa-shopping-cart mr-2"></i> Cart
                <span id="mobile-cart-count" class="ml-1 bg-dark text-white text-xs rounded-full px-2 py-0.5">
                    {{ $cartCount ?? 0 }}
                </span>
            </button>
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="block py-2 text-dark hover:text-black">
                Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark py-6 mt-12 text-white">
        <div class="container mx-auto px-4 text-center">
            <div class="flex justify-center space-x-6 mb-4">
                <a href="#" class="text-white hover:text-primary"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white hover:text-primary"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white hover:text-primary"><i class="fab fa-twitter"></i></a>
            </div>
            <p class="text-white text-sm">&copy; {{ date('Y') }} Crunchy Sweets. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
        });

        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function () {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Cart toggle functionality
        const cartToggle = document.getElementById('cart-toggle');
        const mobileCartToggle = document.getElementById('mobile-cart-toggle');
        const closeCart = document.getElementById('close-cart');
        const sideCart = document.getElementById('side-cart');
        const cartOverlay = document.getElementById('cart-overlay');

        function toggleCart() {
            sideCart.classList.toggle('closed');
            sideCart.classList.toggle('open');
            cartOverlay.classList.toggle('closed');
            cartOverlay.classList.toggle('open');
        }

        if (cartToggle) cartToggle.addEventListener('click', toggleCart);
        if (mobileCartToggle) mobileCartToggle.addEventListener('click', toggleCart);
        if (closeCart) closeCart.addEventListener('click', toggleCart);
        if (cartOverlay) cartOverlay.addEventListener('click', toggleCart);

        // Function to fetch and update cart items
        function fetchCartItems() {
            fetch('{{ route("cart.items") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(html => {
                    document.getElementById('cart-items-container').innerHTML = html;

                    // Update cart total
                    const total = calculateCartTotal();
                    document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;

                    // Update cart count
                    const count = calculateCartCount();
                    updateCartCount(count);
                })
                .catch(error => {
                    console.error('Error fetching cart items:', error);
                });
        }

        // Calculate cart total from displayed items
        function calculateCartTotal() {
            let total = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const price = parseFloat(item.dataset.price);
                const quantity = parseInt(item.dataset.quantity);
                total += price * quantity;
            });
            return total;
        }

        // Calculate cart count from displayed items
        function calculateCartCount() {
            let count = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const quantity = parseInt(item.dataset.quantity);
                count += quantity;
            });
            return count;
        }

        // Update cart count in the header
        function updateCartCount(count) {
            const cartCountElements = document.querySelectorAll('#cart-count, #mobile-cart-count');
            cartCountElements.forEach(el => {
                el.textContent = count;
            });
        }

        // Initial cart load
        document.addEventListener('DOMContentLoaded', function () {
            fetchCartItems();
        });
    </script>

    @stack('scripts')
</body>

</html>