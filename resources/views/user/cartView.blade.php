<!-- Side Cart -->
<div id="cart-overlay" class="cart-overlay closed"></div>

<div id="side-cart" class="side-cart closed">
    <div class="h-full flex flex-col">
        <div class="p-6 border-b border-primary-light flex justify-between items-center bg-primary">
            <h3 class="text-xl font-lora font-bold text-dark">Your Cart</h3>
            <button id="close-cart" class="text-dark hover:text-secondary">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div id="cart-items-container" class="flex-grow overflow-y-auto p-4 space-y-4 bg-primary-light">
            @if($cartItems->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-shopping-cart text-4xl text-dark opacity-30 mb-4"></i>
                    <p class="text-dark text-lg">Your cart is empty</p>
                    <!-- <a href="#categories" class="btn-primary px-6 py-2 rounded-full inline-block mt-4">
                        Browse Sweets
                    </a> -->
                </div>
            @else
                @foreach($cartItems as $item)
                    <div class="cart-item bg-white p-4 rounded-lg shadow-sm flex justify-between items-center"
                        data-price="{{ $item->price }}" data-quantity="{{ $item->quantity }}">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $item->image ? $item->image : 'https://placehold.co/600x400?text=No+Image' }}" alt="{{ $item->name }}"
                                class="w-16 h-16 rounded-lg object-cover">
                            <div>
                                <h4 class="font-medium text-lg text-dark">{{ $item->name }}</h4>
                                <p class="text-gray-600">Rs. {{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <button class="remove-from-cart text-secondary hover:text-secondary-dark p-2" 
                                data-cart-item-id="{{ $item->id }}"
                                aria-label="Remove item">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="p-6 border-t border-primary-light bg-white">
            <div class="flex justify-between items-center mb-6">
                <span class="font-bold text-dark">Total:</span>
                <span id="cart-total" class="font-bold text-dark">Rs. {{ number_format($cartTotal ?? 0, 2) }}</span>
            </div>
            <a href="{{ route('checkout') }}" class="btn-primary w-full py-3 rounded-full text-center block">
                Proceed to Checkout
            </a>
        </div>
    </div>
</div>