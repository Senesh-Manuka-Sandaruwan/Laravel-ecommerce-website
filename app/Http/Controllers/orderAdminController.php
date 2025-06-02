<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderAdminController extends Controller
{
    // Get all orders with user info
    public function getOrders()
    {
        $orders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name', 'users.email as user_email')
            ->orderBy('orders.created_at', 'desc')
            ->get();
        return response()->json(['orders' => $orders]);
    }

    // Get order details with items
    public function getOrder($id)
    {
        $order = DB::table('orders')->where('id', $id)->first();
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $orderItems = DB::table('order_items')
            ->join('items', 'order_items.item_id', '=', 'items.id')
            ->where('order_items.order_id', $id)
            ->select('order_items.*', 'items.name as item_name', 'items.description', 'items.image')
            ->get();
        return response()->json(['order' => $order, 'items' => $orderItems]);
    }

    // Update order status only
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);
        $order = DB::table('orders')->where('id', $id)->first();
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        DB::table('orders')->where('id', $id)->update([
            'order_status' => $request->order_status,
            'updated_at' => now(),
        ]);
        return response()->json(['message' => 'Order status updated successfully']);
    }
}
