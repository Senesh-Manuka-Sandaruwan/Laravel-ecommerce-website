<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function processCheckout(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_type' => 'required|in:credit_card,paypal,cash_on_delivery'
        ]);

        try {
            DB::beginTransaction();

            // Get cart items
            $cartItems = DB::table('cart_items')
                ->join('items', 'cart_items.item_id', '=', 'items.id')
                ->where('cart_items.user_id', Auth::id())
                ->select('cart_items.*', 'items.price')
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Your cart is empty');
            }

            // Calculate total
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });

            // Calculate shipping cost (5% of total)
            $shippingCost = $totalAmount * 0.05;

            // Add shipping cost to total
            $grandTotal = $totalAmount + $shippingCost;

            // Create order
            $orderId = DB::table('orders')->insertGetId([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'payment_type' => $request->payment_type,
                'order_status' => 'pending',
                'total_amount' => $grandTotal,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'item_id' => $item->item_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Clear the cart
            DB::table('cart_items')->where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('order.confirmation', $orderId)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to process your order. Please try again.');
        }
    }

    public function showConfirmation($orderId)
    {
        $order = DB::table('orders')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return redirect()->route('user.home')->with('error', 'Order not found');
        }

        $orderItems = DB::table('order_items')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->where('order_items.order_id', $orderId)
            ->select('order_items.*', 'items.name', 'items.image')
            ->get();

        return view('user.order-confirmation', compact('order', 'orderItems'));
    }
}