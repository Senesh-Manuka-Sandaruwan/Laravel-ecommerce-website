@extends('userLayouts.master')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-lora font-bold mb-8 text-center text-dark">Checkout</h1>

    @if($cartItems->isEmpty())
        <div class="text-center py-8 mb-40">
            <i class="fas fa-shopping-cart text-4xl text-dark opacity-30 mb-4"></i>
            <p class="text-dark text-lg">Your cart is empty</p>
            <a href="{{ route('user.home') }}" class="btn-primary px-6 py-2 rounded-full inline-block mt-4">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Customer Information Form -->
            <div class="bg-white p-6 border border-dark rounded-lg shadow-md">
                <h2 class="text-2xl font-bold mb-4 text-dark">Customer Information</h2>
                <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="customer_name" class="block text-dark mb-2">Full Name</label>
                        <input type="text" id="customer_name" name="customer_name" 
                               value="{{ auth()->user()->name }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-dark" required>
                    </div>

                    <div class="mb-4">
                        <label for="customer_phone" class="block text-dark mb-2">Phone Number</label>
                        <input type="tel" id="customer_phone" name="customer_phone" 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-dark" required>
                    </div>

                    <div class="mb-4">
                        <label for="customer_address" class="block text-dark mb-2">Delivery Address</label>
                        <textarea id="customer_address" name="customer_address" rows="3"
                                  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-dark" required></textarea>
                    </div>

                    <div class="mb-6">
                        <label class="block text-dark mb-2">Payment Method</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="payment_type" value="credit_card" class="mr-2" checked>
                                <span class="text-dark">Card Payment on Delivery</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_type" value="cash_on_delivery" class="mr-2">
                                <span class="text-dark">Cash on Delivery</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="bg-white p-6 rounded-lg border border-dark shadow-md">
                <h2 class="text-2xl font-bold mb-4 text-dark">Order Summary</h2>
                <ul class="space-y-4 mb-6">
                    @foreach($cartItems as $item)
                        <li class="flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $item->image ? $item->image : 'https://placehold.co/600x400?text=No+Image' }}" alt="{{ $item->name }}" 
                                     alt="{{ $item->name }}" 
                                     class="w-16 h-16 rounded-lg object-cover">
                                <div>
                                    <h4 class="font-medium text-lg text-dark">{{ $item->name }}</h4>
                                    <p class="text-gray-600">Rs. {{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                                </div>
                            </div>
                            <span class="font-bold text-dark">Rs. {{ number_format($item->price * $item->quantity, 2) }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="border-t border-primary-light pt-4 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-dark">Subtotal</span>
                        <span class="text-dark">Rs. {{ number_format($cartTotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-dark">Shipping</span>
                        <span class="text-dark">Rs. {{ number_format($cartTotal * 0.05, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center font-bold text-lg">
                        <span class="text-dark">Total</span>
                        <span class="text-dark">Rs. {{ number_format($cartTotal + ($cartTotal * 0.05), 2) }}</span>
                    </div>
                </div>

                <button type="submit" form="checkout-form" 
                        class="btn-primary w-full py-3 rounded-full text-lg font-medium hover:shadow-lg">
                    Place Order
                </button>
            </div>
        </div>
    @endif
</div>
@endsection