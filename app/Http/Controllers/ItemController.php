<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{

public function index(Request $request)
{
    $query = \DB::table('items');

    // Search functionality
    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('name', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
    }

    // Get all items
    $items = $query->get();

    $categories = \DB::table('categories')->get();
    return view('admin.items', ['items' => $items, 'categories' => $categories]);
}

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'category_id' => 'required|integer|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|string|url',
    ]);

    

    $id = \DB::table('items')->insertGetId([
        'name' => $request->input('name'),
        'description' => $request->input('description'),
        'category_id' => $request->input('category_id'),
        'price' => $request->input('price'),
        'image' => $request->input('image'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json(['message' => 'Item created successfully', 'id' => $id]);
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
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string|url',
        ]);

        $updated = \DB::table('items')
            ->where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'category_id' => $request->input('category_id'),
                'price' => $request->input('price'),
                'image' => $request->input('image'),
                'updated_at' => now(),
            ]);

        if (!$updated) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json(['message' => 'Item updated successfully']);
    }

    public function destroy($id)
    {
        $deleted = \DB::table('items')->where('id', $id)->delete();
        if (!$deleted) {
            return redirect()->route('items.index')->with('error', 'Item not found');
        }
        return redirect()->route('items.index')->with('success', 'Item deleted successfully');
    }
}
