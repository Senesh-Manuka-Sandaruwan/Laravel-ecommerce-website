@extends('userLayouts.master')

@section('title', 'Crunchy Sweets Shop')

@section('content')
<div class="container mx-auto px-4 py-8" id="home">
    <!-- Hero Section -->
    <section class="mb-16" data-aos="fade-up">
        <div class="bg-gradient-to-r from-primary-light to-primary rounded-3xl p-8 md:p-12 text-center">
            <h1 class="text-4xl md:text-5xl font-lora font-bold mb-6 text-dark">Crunchy Sweets Shop</h1>
            <p class="text-lg mb-8 text-gray-700 max-w-2xl mx-auto">Handcrafted with love using the finest ingredients.
                Our sweets make every moment special.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="javascript:void(0);"
                onclick="document.getElementById('categories').scrollIntoView({ behavior: 'smooth' });" class="btn-primary px-8 py-3 rounded-full text-lg font-medium">Browse Sweets</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section id="categories" class="mb-16" data-aos="fade-up">
        <h2 class="text-3xl font-lora font-bold mb-8 text-center text-dark">Our Sweet Categories</h2>
        <div class="flex flex-wrap justify-center gap-4 mb-8">
            <button
                class="category-filter px-6 py-2 bg-primary text-dark rounded-full hover:bg-dark hover:text-white transition-colors duration-300"
                data-category="all">
                All Items
            </button>
            @foreach($categories as $category)
                <button
                    class="category-filter px-6 py-2 bg-primary text-dark rounded-full hover:bg-dark hover:text-white transition-colors duration-300"
                    data-category="{{ $category->id }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </section>

    <!-- Items Section -->
    <section class="mb-16" data-aos="fade-up">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h2 class="text-2xl font-lora text-dark">Our Sweets</h2>
            <div class="relative w-full md:w-64 mt-4 md:mt-0">
                <input type="text" id="search-input" placeholder="Search sweets..."
                    class="w-full px-4 py-2 border border-dark rounded-full focus:outline-none focus:ring-1 focus:ring-primary-dark placeholder-dark">
                <i class="fas fa-search absolute right-3 top-3 text-dark"></i>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="items-container">
            @foreach($items as $item)
                <div class="card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg"
                    data-category="{{ $item->category_id }}">
                    <div class="relative">
                        <img src="{{ $item->image ? $item->image : 'https://placehold.co/600x400?text=No+Image' }}" alt="{{ $item->name }}"
                            class="w-full h-48 object-cover">
                        <div class="absolute top-0 right-0 bg-primary text-dark px-3 py-1 rounded-bl-lg">
                            Rs. {{ number_format($item->price, 2) }}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-lora mb-2 text-dark">{{ $item->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $item->description }}</p>
                        <button class="add-to-cart-btn w-full btn-primary py-2 rounded-full" data-item-id="{{ $item->id }}">
                            <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

    </section>
</div>

@include('user.cartView')
@push('styles')
<style>
    .notification {
        position: fixed;
        top: 80px;
        right: 20px;
        z-index: 1050;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: bold;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: opacity 0.5s ease, transform 0.5s ease;
    }

    .notification.success {
        background-color: #38a169;
        color: white;
    }

    .notification.error {
        background-color: #e53e3e;
        color: white;
    }

    .notification.info {
        background-color: #3182ce;
        color: white;
    }

    .notification.hide {
        opacity: 0;
        transform: translateY(-20px);
    }
</style>
@endpush
@push('scripts')
<script>
    // Add to cart functionality
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function () {
            const itemId = this.getAttribute('data-item-id');
            const button = this;

            // Add loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Adding...';
            button.disabled = true;

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: 1
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    // Reload cart items
                    fetchCartItems();
                    // Update cart count
                    if (data.cart_count !== undefined) {
                        updateCartCount(data.cart_count);
                    }
                    // Show success notification
                    showNotification(data.message || 'Item added to cart!', 'success');
                    // Open cart if it's closed
                    if (sideCart.classList.contains('closed')) {
                        toggleCart();
                    }
                })
                .catch(error => {
                    showNotification(error.message || 'Failed to add item to cart', 'error');
                    console.error('Error:', error);
                })
                .finally(() => {
                    // Reset button state
                    button.innerHTML = '<i class="fas fa-cart-plus mr-2"></i> Add to Cart';
                    button.disabled = false;
                });
        });
    });

    // Filter items by category
    document.querySelectorAll('.category-filter').forEach(button => {
        button.addEventListener('click', function () {
            const categoryId = this.getAttribute('data-category');
            const items = document.querySelectorAll('#items-container > div');

            // Update active button styling
            document.querySelectorAll('.category-filter').forEach(btn => {
                btn.classList.remove('bg-dark', 'text-white', 'shadow-md');
                btn.classList.add('bg-primary');
            });
            this.classList.remove('bg-primary');
            this.classList.add('bg-dark', 'text-white', 'shadow-md');

            items.forEach(item => {
                if (categoryId === 'all' || item.getAttribute('data-category') === categoryId) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Search functionality
    document.getElementById('search-input').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        const items = document.querySelectorAll('#items-container > div');

        items.forEach(item => {
            const name = item.querySelector('h3').textContent.toLowerCase();
            const description = item.querySelector('p').textContent.toLowerCase();

            if (name.includes(searchTerm) || description.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Remove item from cart
    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-from-cart')) {
            e.preventDefault();
            const cartItemId = e.target.closest('.remove-from-cart').getAttribute('data-cart-item-id');

            fetch('{{ route("cart.remove", "") }}/' + cartItemId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        // Reload cart items
                        fetchCartItems();
                        // Update cart count
                        if (data.cart_count !== undefined) {
                            updateCartCount(data.cart_count);
                        }
                        // Show success notification
                        showNotification('Item removed from cart', 'info');
                    }
                })
                .catch(error => {
                    console.error('Error removing item from cart:', error);
                    showNotification('Failed to remove item from cart', 'error');
                });
        }
    });

    // Show notification
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('hide');
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
</script>
@endpush
@endsection