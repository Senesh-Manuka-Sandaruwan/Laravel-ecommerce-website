<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemsController extends Controller
{
    public function index(Request $request)
    {
        $items = \DB::table('items')->get();


        return response()->json([
            'items' => $items,
            
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|url',
        ]);
    
        $id = \DB::table('items')->insertGetId([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'image' => $validated['image'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return response()->json([
            'message' => 'Item created successfully', 
            'id' => $id
        ], 201);
    }

    public function show($id)
    {
        $item = \DB::table('items')->find($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        return response()->json($item);
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_id' => 'required|integer|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|url|max:255', // Changed to validate URL
    ]);

    $updated = \DB::table('items')
        ->where('id', $id)
        ->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'image' => $validated['image'] ?? null,
            'updated_at' => now(),
        ]);

    if (!$updated) {
        return response()->json(['message' => 'Item not found or not updated'], 404);
    }

    return response()->json(['message' => 'Item updated successfully']);
}

    public function destroy($id)
    {
        $deleted = \DB::table('items')->where('id', $id)->delete();
        if (!$deleted) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        return response()->json(['message' => 'Item deleted successfully']);
    }
}
