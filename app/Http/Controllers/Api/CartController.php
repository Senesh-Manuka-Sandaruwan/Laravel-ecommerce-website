<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\LogService;
use Illuminate\Support\Facades\Log;


class CartController extends Controller
{
    protected $logService;
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }
    // Add item to cart
    public function addToCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $user = $request->attributes->get('user');

        $userId = $user->tokenable_id; 
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Check if item already exists in cart for this user
        $cartItem = DB::table('cart_items')
            ->where('user_id', $userId)
            ->where('item_id', $request->item_id)
            ->first();

        if ($cartItem) {
            // Update quantity
            DB::table('cart_items')
                ->where('id', $cartItem->id)
                ->update([
                    'quantity' => $cartItem->quantity + $request->quantity,
                    'price' => $request->price,
                    'updated_at' => now(),
                ]);
        } else {
            // Insert new cart item
            DB::table('cart_items')->insert([
                'user_id' => $userId,
                'item_id' => $request->item_id,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Item added to cart successfully']);
    }

    // Delete a single item from cart
    public function deleteItem(Request $request)
    {
        
        $request->validate([
            'item_id' => 'required',
        ]);
        $user = $request->attributes->get('user');

        $userId = $user->tokenable_id;
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        DB::table('cart_items')
            ->where('user_id', $userId)
            ->where('id', $request->item_id)
            ->delete();
        return response()->json(['message' => 'Item removed from cart']);
    }

    // Delete all items from cart
    public function clearCart(Request $request)
    {
        try {
            $user = $request->attributes->get('user');
           

            $userId = $user->tokenable_id;
            if (!$userId) {
                return response()->json(['error' => 'User not authenticated'], 401);
            }
             DB::table('cart_items')
                ->where('user_id', $userId)
                ->delete();
            // Log the action
            Log::info('All items removed from cart for user ID: ' . $userId);
            Log::info('Response: All items removed from cart'.response()->json(['message' => 'All items removed from cart']));
            return response()->json(['message' => 'All items removed from cart']);
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Failed to clear cart: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to clear cart', 'details' => $e->getMessage()], 500);
        }
    }

    // Get cart with items and item details
    public function getCart(Request $request)
    {
        $user = $request->attributes->get('user');

        $userId = $user->tokenable_id;
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $cartItems = DB::table('cart_items')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['cart' => [], 'message' => 'Cart is empty']);
        }

        // Get item details for each cart item
        $itemIds = $cartItems->pluck('item_id')->toArray();
        $items = DB::table('items')->whereIn('id', $itemIds)->get()->keyBy('id');

        $cart = $cartItems->map(function ($cartItem) use ($items) {
            $itemDetail = $items[$cartItem->item_id] ?? null;
            return [
                'id' => $cartItem->id,
                'item_id' => $cartItem->item_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'item' => $itemDetail,
            ];
        });

        return response()->json(['cart' => $cart]);
    }

    //get item count under same user id 
    public function getItemCount(Request $request)
    {
        $user = $request->attributes->get('user');

        $userId = $user->tokenable_id;
        if (!$userId) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }
        $itemCount = DB::table('cart_items')
            ->where('user_id', $userId)
            ->sum('quantity');

        return response()->json(['item_count' => $itemCount]);
    }
}
