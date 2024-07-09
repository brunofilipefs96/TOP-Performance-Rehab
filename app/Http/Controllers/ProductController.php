<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Product::class);
        $search = request('search');
        if($search){
            $products = Product::where([
                ['name', 'like', '%'.$search.'%']
            ])->paginate(12);
            return view('pages.products.index', ['products' => $products]);
        }
        $products = Product::orderBy('id', 'desc')->paginate(12);
        return view('pages.products.index', ['products' => $products]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Product::class);
        return view('pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();
        $product = new Product($validatedData);
        $product->save();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName = $product->id . '_' . time() . '_' . $imagePath->getClientOriginalName();
            $path = $request->file('image')->storeAs('images/products/' . $product->id, $imageName, 'public');
            $validatedData['image'] = $path;
            $product->image = $path;
        }
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);
        return view('pages.products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('pages.products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image');
            $imageName = $product->id . '_' . time() . '_' . $imagePath->getClientOriginalName();
            $path = $request->file('image')->storeAs('images/products/' . $product->id, $imageName, 'public');
            Storage::delete('public/' . $product->image);
            $validatedData['image'] = $path;
        }
        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        Storage::deleteDirectory('public/images/products/' . $product->id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

}
