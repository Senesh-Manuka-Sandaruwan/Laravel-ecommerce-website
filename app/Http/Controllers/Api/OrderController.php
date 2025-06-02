<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;






class OrderController extends Controller
{

    // Get all orders for the authenticated user
    public function index(Request $request)
    {
        $user = $request->attributes->get('user');
        $userId = $user->tokenable_id; // Assuming the user ID is stored in the tokenable_id field

        $orders = DB::table('orders')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Attach order items to each order
        foreach ($orders as $order) {
            $order->order_items = DB::table('order_items')
                ->where('order_id', $order->id)
                ->get();
        }

        return response()->json($orders);
    }
    // Add a new order
    public function store(Request $request)
    {
        $user = $request->attributes->get('user');
        $userId = $user->tokenable_id; // Assuming the user ID is stored in the tokenable_id field

        $validated = $request->validate([
            
            'customer_phone' => 'required',
            'customer_address' => 'required',
            'payment_type' => 'required',
            'order_items' => 'required|array',
            'order_items.*.item_id' => 'required',
            'order_items.*.quantity' => 'required',
            'order_items.*.price' => 'required',
            'total_amount' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $orderId = DB::table('orders')->insertGetId([
                'user_id' => $userId,
                'customer_name' => $user->name,
                'customer_phone' => $validated['customer_phone'],
                'customer_address' => $validated['customer_address'],
                'payment_type' => $validated['payment_type'],
                'total_amount' => $validated['total_amount'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($validated['order_items'] as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Order created successfully', 'order_id' => $orderId], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create order', 'details' => $e->getMessage()], 500);
        }
    }

    // Get order details by order id
    public function show($id)
    {
        $order = DB::table('orders')->where('id', $id)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $orderItems = DB::table('order_items')->where('order_id', $id)->get();

        return response()->json([
            'order' => $order,
            'order_items' => $orderItems,
        ]);
    }
}