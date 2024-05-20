<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(15);
        return view('pages.products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::allows('create', Product::class)) {
            return view('pages.products.create');
        } else {
            return redirect()->route('products.index')->with('error', 'You are not authorized to create a product.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        if (Gate::allows('create', Product::class)) {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $validatedData['image'] = $path;
            }

            Product::create($validatedData);

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } else {
            return redirect()->route('products.index')->with('error', 'You are not authorized to create a product.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('pages.products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (Gate::allows('update', $product)) {
            return view('pages.products.edit', ['product' => $product]);
        } else {
            return redirect()->route('products.index')->with('error', 'You are not authorized to update this product.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if (Gate::allows('update', $product)) {
            $validatedData = $request->validated();

            if ($request->hasFile('image')) {
                /*if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }*/

                $path = $request->file('image')->store('products', 'public');
                $validatedData['image'] = $path;
            }

            $product->update($validatedData);

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } else {
            return redirect()->route('products.index')->with('error', 'You are not authorized to update this product.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (Gate::allows('delete', $product)) {
            /*if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }*/

            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } else {
            return redirect()->route('products.index')->with('error', 'You are not authorized to delete this product.');
        }
    }
}
