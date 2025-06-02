<?php
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    // Display cart items
    public function index(Request $request)
{
    try {
        $cartItems = DB::table('cart_items')
            ->join('items', 'cart_items.item_id', '=', 'items.id')
            ->where('cart_items.user_id', auth()->id())
            ->select(
                'cart_items.id',
                'cart_items.item_id',
                'cart_items.quantity',
                'cart_items.price',
                'items.name',
                'items.image',
                'items.description'
            )
            ->get();

        $cartTotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // Return only the cart items partial view
        return view('user.cart', compact('cartItems', 'cartTotal'));
    } catch (\Exception $e) {
        \Log::error('Error fetching cart items: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to fetch cart items'], 500);
    }
}

    // Add item to cart
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'item_id' => 'required|exists:items,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $item = DB::table('items')->where('id', $request->item_id)->first();
            if (!$item) {
                return response()->json(['error' => 'Item not found'], 404);
            }

            $cartItem = DB::table('cart_items')
                ->where('user_id', auth()->id())
                ->where('item_id', $request->item_id)
                ->first();

            if ($cartItem) {
                DB::table('cart_items')
                    ->where('id', $cartItem->id)
                    ->update([
                        'quantity' => DB::raw('quantity + ' . $request->quantity),
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('cart_items')->insert([
                    'user_id' => auth()->id(),
                    'item_id' => $request->item_id,
                    'quantity' => $request->quantity,
                    'price' => $item->price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return response()->json([
                'message' => 'Item added to cart successfully',
                'cart_count' => $this->getCartCount()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Delete item from cart
    public function removeFromCart($id)
    {
        try {
            $cartItem = DB::table('cart_items')
                ->where('id', $id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$cartItem) {
                return response()->json(['error' => 'Cart item not found'], 404);
            }

            DB::table('cart_items')->where('id', $id)->delete();

            return response()->json([
                'message' => 'Item removed from cart successfully',
                'cart_count' => $this->getCartCount()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Helper function to get cart count
    private function getCartCount()
    {
        return DB::table('cart_items')
            ->where('user_id', auth()->id())
            ->sum('quantity');
    }

    public function checkout()
{
    try {
        $cartItems = DB::table('cart_items')
            ->join('items', 'cart_items.item_id', '=', 'items.id')
            ->where('cart_items.user_id', auth()->id())
            ->select(
                'cart_items.id',
                'cart_items.item_id',
                'cart_items.quantity',
                'cart_items.price',
                'items.name',
                'items.image',
                'items.description'
            )
            ->get();

        $cartTotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('user.checkout', compact('cartItems', 'cartTotal'));
    } catch (\Exception $e) {
        \Log::error('Error loading checkout page: ' . $e->getMessage());
        return redirect()->route('user.home')->with('error', 'Failed to load checkout page.');
    }
}
}