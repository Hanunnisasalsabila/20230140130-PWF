<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
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
        $validated['user_id'] = Auth::id();
        try {
            Product::create($validated);
            return redirect()->route('product.index')->with('success', 'Product created successfully.');

        } catch (\Throwable $e) {
            Log::error('Product store unexpected error', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Unexpected error occurred.');
        }
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $categories = Category::all();

        return view('product.create', compact('users', 'categories'));
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

        try {
            $product->update($request->validated());
            return redirect()->route('product.index')->with('success', 'Product updated successfully.');

        } catch (\Throwable $e) {
            Log::error('Product update unexpected error', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Unexpected error occurred while updating.');
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $users = User::orderBy('name')->get();
        
        return view('product.edit', compact('product', 'users', 'categories'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('delete', $product);
        
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}