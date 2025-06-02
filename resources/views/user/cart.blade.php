@if($cartItems->isEmpty())
    <div class="text-center py-8">
        <i class="fas fa-shopping-cart text-4xl text-gray-400 mb-4"></i>
        <p class="text-gray-600 text-lg">Your cart is empty</p>
        <!-- <a href="#categories" class="btn-pink px-6 py-2 rounded-full inline-block mt-4">
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
                    <h4 class="font-medium text-lg">{{ $item->name }}</h4>
                    <p class="text-gray-600">Rs. {{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                </div>
            </div>
            <button class="remove-from-cart text-red-500 hover:text-red-700 p-2" data-cart-item-id="{{ $item->id }}"
                    aria-label="Remove item">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>
    @endforeach
@endif