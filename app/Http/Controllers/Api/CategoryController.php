<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;




class CategoryController extends Controller
{
    // GET /api/categories
    public function index()
    {
        $categories = \DB::table('categories')->get();
        return response()->json($categories);
    }

    // GET /api/categories/{id}
    public function show($id)
    {
        $category = \DB::table('categories')->where('id', $id)->first();
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    // POST /api/categories
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $id = \DB::table('categories')->insertGetId([
            'name' => $validated['name'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $category = \DB::table('categories')->where('id', $id)->first();

        return response()->json($category, 201);
    }

    // PUT /api/categories/{id}
    public function update(Request $request, $id)
    {
        $category = \DB::table('categories')->where('id', $id)->first();
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        \DB::table('categories')->where('id', $id)->update([
            'name' => $validated['name'],
            'updated_at' => now(),
        ]);

        $updatedCategory = \DB::table('categories')->where('id', $id)->first();

        return response()->json($updatedCategory);
    }

    // DELETE /api/categories/{id}
    public function destroy($id)
    {
        $category = \DB::table('categories')->where('id', $id)->first();
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        \DB::table('categories')->where('id', $id)->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}