<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Success', 'data' => Category::all()], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|unique:categories,name']);
        $category = Category::create($validated);
        return response()->json(['message' => 'Kategori ditambahkan', 'data' => $category], 201);
    }

    public function show(int $id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        return response()->json(['message' => 'Success', 'data' => $category], 200);
    }

    public function update(Request $request, int $id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'Kategori tidak ditemukan'], 404);

        $validated = $request->validate(['name' => 'required|string|unique:categories,name,' . $id]);
        $category->update($validated);
        return response()->json(['message' => 'Kategori diupdate', 'data' => $category], 200);
    }

    public function destroy(int $id)
    {
        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'Kategori tidak ditemukan'], 404);

        $category->delete();
        return response()->json(['message' => 'Kategori dihapus'], 200);
    }
}