<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Membership;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Pack;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        return view('pages.cart.index');
    }

    public function addProductToCart(Request $request)
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

    public function addPackToCart(Request $request)
    {
        $packId = $request->input('pack_id');
        $pack = Pack::find($packId);

        if (!$pack) {
            return redirect()->route('packs.index')->with('error', 'Pack not found!');
        }

        // Add pack to cart
        $packCart = session()->get('packCart', []);

        // Check if pack is already in cart
        if (isset($packCart[$packId])) {
            return redirect()->route('packs.index')->with('error', 'Pack already in cart!');
        } else {
            $packCart[$packId] = [
                'name' => $pack->name,
                'price' => $pack->price,
                'quantity' => 1
            ];
        }

        // Save the cart back to the session
        session()->put('packCart', $packCart);

        return redirect()->route('packs.index')->with('success', 'Pack added to cart successfully!');
    }

    public function removeProductFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully!');
        }

        return redirect()->route('cart.index')->with('error', 'Product not found in cart!');
    }

    public function removePackFromCart($id)
    {
        $packCart = session()->get('packCart', []);

        if (isset($packCart[$id])) {
            unset($packCart[$id]);
            session()->put('packCart', $packCart);
            return redirect()->route('cart.index')->with('success', 'Pack removed from cart successfully!');
        }

        return redirect()->route('cart.index')->with('error', 'Pack not found in cart!');
    }

    public function increaseProductQuantity($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;

            // Check if cart quantity exceeds stock
            $product = Product::find($id);
            if ($cart[$id]['quantity'] > $product->quantity) {
                session()->flash('error', 'The quantity of ' . $product->name . ' exceeds available stock.');
                session()->flash('warning', 'The order might take longer due to stock shortage.');
            }

            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index');
    }

    public function decreaseProductQuantity($id)
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

    public function checkout()
    {
        $addresses = auth()->user()->addresses;
        $cart = session()->get('cart', []);
        $packCart = session()->get('packCart', []);

        if (empty($cart) && empty($packCart)) {
            return redirect()->route('cart.index')->with('error', 'O carrinho está vazio.');
        }

        return view('pages.cart.checkout', ['addresses' => $addresses, 'cart' => $cart, 'packCart' => $packCart]);
    }

    public function processCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required_without:new_address|exists:addresses,id',
            'new_address' => 'sometimes|boolean',
            'name' => 'required_if:new_address,1|max:50',
            'street' => 'required_if:new_address,1|max:100',
            'city' => 'required_if:new_address,1|max:50',
            'postal_code' => 'required_if:new_address,1|regex:/\d{4}-\d{3}/',
            'nif_option' => 'required|in:personal,final',
            'payment_method' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->input('new_address')) {
            $address = new Address();
            $address->name = $request->input('name');
            $address->street = $request->input('street');
            $address->city = $request->input('city');
            $address->postal_code = $request->input('postal_code');
            $address->user_id = auth()->id();
            $address->save();
            $addressId = $address->id;
        } else {
            $addressId = $request->input('address_id');
        }

        $nif = $request->input('nif_option') === 'personal' ? auth()->user()->nif : '999999990';

        $cart = session()->get('cart', []);
        $packCart = session()->get('packCart', []);
        $total = 0;

        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        foreach ($packCart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $sale = Sale::create([
            'user_id' => auth()->id(),
            'address_id' => $addressId,
            'status_id' => 1,
            'total' => $total,
            'payment_method' => $request->input('payment_method'),
            'nif' => $nif,
        ]);

        foreach ($cart as $id => $details) {
            $sale->products()->attach($id, [
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);

            $product = Product::find($id);
            $product->quantity -= $details['quantity'];
            $product->save();
        }

        $membership = Membership::where('user_id', auth()->id())->firstOrFail();
        foreach ($packCart as $id => $details) {
            $sale->packs()->attach($id, [
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);

            $pack = Pack::find($id);
            $membership->packs()->attach($id, [
                'quantity' => $details['quantity'],
                'quantity_remaining' => $details['quantity'],
                'expiry_date' => Carbon::now()->addDays($pack->duration),
            ]);
        }

        session()->forget('cart');
        session()->forget('packCart');

        return redirect()->route('sales.index')->with('success', 'Compra realizada com sucesso!');
    }
}