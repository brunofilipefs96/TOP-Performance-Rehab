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

    public function cart()
    {
        $this->authorize('viewAny', Product::class);
        return view('pages.cart.index');
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Product not found!');
        }

        // Add product to cart
        $cart = session()->get('cart', []);

        // Check if product is already in cart
        if (isset($cart[$productId])) {
            // Check if there is enough stock to add one more unit
            if ($product->quantity > $cart[$productId]['quantity']) {
                // Increment quantity
                $cart[$productId]['quantity']++;
            } else {
                return redirect()->route('products.index')->with('error', 'Not enough stock for this product!');
            }
        } else {
            // Add new product to cart with quantity 1
            if ($product->quantity > 0) {
                $cart[$productId] = [
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1
                ];
            } else {
                return redirect()->route('products.index')->with('error', 'Not enough stock for this product!');
            }
        }

        // Save the cart back to the session
        session()->put('cart', $cart);

        return redirect()->route('products.index')->with('success', 'Product added to cart successfully!');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Produto removido do carrinho com sucesso!');
        }

        return redirect()->route('cart.index')->with('error', 'Produto não encontrado no carrinho!');
    }

    public function increaseQuantity($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;

            // Check if cart quantity exceeds stock
            $product = Product::find($id);
            if ($cart[$id]['quantity'] > $product->quantity) {
                session()->flash('error', 'A quantidade de ' . $product->name . ' excedeu a quantidade disponível em stock.');
                session()->flash('warning', 'A encomenda poderá demorar mais que o esperado devido à falta de stock.');
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function decreaseQuantity($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']--;
            if ($cart[$id]['quantity'] <= 0) {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }



}
