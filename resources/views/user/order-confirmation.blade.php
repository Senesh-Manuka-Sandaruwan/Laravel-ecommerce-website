@extends('userLayouts.master')

@section('title', 'Order Confirmation')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-md border border-dark text-center max-w-2xl mx-auto">
        <div class="text-accent text-6xl mb-4">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="text-3xl font-lora font-bold mb-4 text-dark">Thank You for Your Order!</h1>
        <p class="text-dark mb-6">Your order #{{ $order->id }} has been placed successfully.</p>
        
        <div class="bg-primary-light p-4 rounded-lg mb-6 text-left">
            <h2 class="text-xl font-bold mb-2 text-dark">Order Summary</h2>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-dark">Order Number</p>
                    <p class="font-medium">{{ $order->id }}</p>
                </div>
                <div>
                    <p class="text-dark">Date</p>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-dark">Total</p>
                    <p class="font-medium">Rs. {{ number_format($order->total_amount, 2) }}</p>
                </div>
                <div>
                    <p class="text-dark">Payment Method</p>
                    <p class="font-medium">{{ ucwords(str_replace('_', ' ', $order->payment_type)) }}</p>
                </div>
            </div>
            
            <h3 class="font-bold mt-4 mb-2 text-dark">Delivery Address</h3>
            <p class="text-dark">{{ $order->customer_address }}</p>
        </div>

        <div class="mb-6">
            <h2 class="text-xl font-bold mb-4 text-dark">Order Items</h2>
            <ul class="space-y-4">
                @foreach($orderItems as $item)
                    <li class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $item->image ? $item->image : 'https://placehold.co/600x400?text=No+Image' }}" alt="{{ $item->name }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-16 h-16 rounded-lg object-cover">
                            <div>
                                <h4 class="font-medium text-dark">{{ $item->name }}</h4>
                                <p class="text-dark">Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <span class="font-bold text-dark">Rs. {{ number_format($item->price * $item->quantity, 2) }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <a href="{{ route('user.home') }}" class="btn-primary px-8 py-3 rounded-full inline-block hover:shadow-lg">
            Continue Shopping
        </a>
    </div>
</div>
@endsection