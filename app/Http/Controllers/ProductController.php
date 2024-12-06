<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
    {
    /**
     * Display a listing of the products.
     */
    public function index()
        {
        // Get products for the authenticated user
        $products = Product::where('user_id', Auth::id())->get();

        return view('products.index', compact('products'));
        }

    /**
     * Show the form for creating a new product.
     */
    public function create()
        {
        return view('products.create');
        }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
        {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // Optional image, max size 2MB
        ]);

        // Handle the image upload if provided
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            }

        // Create the product and associate it with the authenticated user
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
        }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
        {
        // Ensure the product belongs to the authenticated user
        $this->authorize('view', $product);

        return view('products.show', compact('product'));
        }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
        {
        // Ensure the product belongs to the authenticated user
        $this->authorize('update', $product);

        return view('products.edit', compact('product'));
        }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
        {
        // Ensure the product belongs to the authenticated user
        $this->authorize('update', $product);

        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        // Handle the image upload if provided
        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            }

        // Update the product
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
        {
        // Ensure the product belongs to the authenticated user
        $this->authorize('delete', $product);

        // Delete the product
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        }
    }
