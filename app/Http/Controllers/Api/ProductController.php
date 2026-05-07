<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    // GET: Ambil Semua Data
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json(['message' => 'Success', 'data' => $products], 200);
    }

    // POST: Tambah Data Baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'qty' => 'required|integer',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);
        $validated['user_id'] = Auth::id();

        $product = Product::create($validated);
        return response()->json(['message' => 'Produk berhasil ditambahkan', 'data' => $product], 201);
    }

    // GET: Ambil Satu Data
    public function show(int $id)
    {
        $product = Product::with('category')->find($id);
        if (!$product) return response()->json(['message' => 'Product tidak ditemukan'], 404);
        return response()->json(['message' => 'Success', 'data' => $product], 200);
    }

    // PUT: Update Data (TUGAS)
    public function update(Request $request, int $id)
    {
        $product = Product::find($id);
        if (!$product) return response()->json(['message' => 'Product tidak ditemukan'], 404);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'qty' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        $product->update($validated);
        return response()->json(['message' => 'Produk berhasil diupdate', 'data' => $product], 200);
    }

    // DELETE: Hapus Data (TUGAS)
    public function destroy(int $id)
    {
        $product = Product::find($id);
        if (!$product) return response()->json(['message' => 'Product tidak ditemukan'], 404);

        $product->delete();
        return response()->json(['message' => 'Produk berhasil dihapus'], 200);
    }
}