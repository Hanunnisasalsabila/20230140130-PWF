<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Mengambil data kategori dan menghitung total produk di masing-masing kategori
        $categories = Category::withCount('products')->get();
        
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Kategori ini sudah ada, silakan gunakan nama lain.'
        ]);

        // Simpan ke database
        Category::create([
            'name' => $request->name
        ]);

        // Kembalikan ke halaman list
        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan!');
    }
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input (Pengecualian unique untuk nama kategori yang sedang diedit)
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Kategori ini sudah ada, silakan gunakan nama lain.'
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus!');
    }
}