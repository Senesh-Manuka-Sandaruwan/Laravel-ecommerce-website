<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        $categories = \DB::table('categories')->get();
        return view('admin.categories', ['categories' => $categories]);
    }

    // Store a newly created category in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $id = \DB::table('categories')->insertGetId([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Category created successfully', 'id' => $id]);
    }

    // Display the specified category
    public function show($id)
    {
        $category = \DB::table('categories')->find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    // Update the specified category in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $updated = \DB::table('categories')
            ->where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'updated_at' => now(),
            ]);

        if (!$updated) {
            return response()->json(['message' => 'Category not found or not updated'], 404);
        }

        return response()->json(['message' => 'Category updated successfully']);
    }

    // Remove the specified category from storage
    public function destroy($id)
    {
        $deleted = \DB::table('categories')->where('id', $id)->delete();
        if (!$deleted) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json(['message' => 'Category deleted successfully']);
    }
}