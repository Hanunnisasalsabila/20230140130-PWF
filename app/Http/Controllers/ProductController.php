<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
// use App\Models\User; // Bisa di-comment karena sudah tidak dipakai
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        
        return view('product.index', compact('products'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        
        // Otomatis mengisi user_id dengan ID admin yang sedang login
        $validated['user_id'] = Auth::id();

        $product = Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function create()
    {
        // $users = User::orderBy('name')->get(); <-- Di-comment
        
        return view('product.create'); // compact dihapus karena tidak butuh data user lagi
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        return view('product.view', compact('product'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('update', $product);
        
        $product->update($request->validated());

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function edit(Product $product)
    {
        // $users = User::orderBy('name')->get(); <-- Di-comment
        
        return view('product.edit', compact('product')); // compact('users') dihapus
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('delete', $product);
        
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}