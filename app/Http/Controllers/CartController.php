<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Pack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Stripe\StripeClient;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $packCart = session()->get('packCart', []);
        $warnings = [];

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product && $details['quantity'] > $product->quantity) {
                $warnings[] = $product->name;
            }
        }

        $warningMessage = '';
        if (!empty($warnings)) {
            $warningMessage = 'A quantidade de ' . implode(' e ', $warnings) . ' excede o stock disponível. O pedido poderá demorar mais tempo.';
        }

        return view('pages.cart.index', ['warningMessage' => $warningMessage]);
    }

    public function addProductToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Produto não encontrado!');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('products.index')->with('success', 'Produto adicionado ao carrinho com sucesso!');
    }

    public function addPackToCart(Request $request)
    {
        $packId = $request->input('pack_id');
        $pack = Pack::find($packId);

        if (!$pack) {
            return redirect()->route('packs.index')->with('error', 'Pack não encontrado!');
        }

        $membership = auth()->user()->membership;
        if (!$membership || $membership->status->name !== 'active') {
            return redirect()->route('packs.index')->with('error', 'Necessita de ter uma matrícula ativa para adicionar packs ao carrinho.');
        }

        $packCart = session()->get('packCart', []);

        if (isset($packCart[$packId])) {
            return redirect()->route('packs.index')->with('error', 'Pack já está no carrinho!');
        } else {
            $packCart[$packId] = [
                'name' => $pack->name,
                'price' => $pack->price,
                'quantity' => 1
            ];
        }

        session()->put('packCart', $packCart);

        return redirect()->route('packs.index')->with('success', 'Pack adicionado ao carrinho com sucesso!');
    }

    public function removeProductFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Produto removido do carrinho com sucesso!');
        }

        return redirect()->route('cart.index')->with('error', 'Produto não encontrado no carrinho!');
    }

    public function removePackFromCart($id)
    {
        $packCart = session()->get('packCart', []);

        if (isset($packCart[$id])) {
            unset($packCart[$id]);
            session()->put('packCart', $packCart);
            return redirect()->route('cart.index')->with('success', 'Pack removido do carrinho com sucesso!');
        }

        return redirect()->route('cart.index')->with('error', 'Pack não encontrado no carrinho!');
    }

    public function increaseProductQuantity($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
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
            'nif_option' => 'required|in:personal,final',
            'new_address' => 'nullable|in:on',
        ]);

        if ($request->input('new_address') === 'on') {
            $validator->after(function ($validator) use ($request) {
                $additionalRules = [
                    'name' => 'required|string|max:255',
                    'street' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'postal_code' => [
                        'required',
                        'string',
                        'max:8',
                        function ($attribute, $value, $fail) {
                            if (!preg_match('/^\d{4}-\d{3}$/', $value)) {
                                $fail('O campo ' . $attribute . ' deve estar no formato xxxx-xxx.');
                            }
                        },
                    ],
                ];

                $additionalValidator = Validator::make($request->all(), $additionalRules);

                if ($additionalValidator->fails()) {
                    foreach ($additionalValidator->errors()->messages() as $field => $messages) {
                        foreach ($messages as $message) {
                            $validator->errors()->add($field, $message);
                        }
                    }
                }
            });
        } else {
            $validator->addRules([
                'address_id' => 'required|exists:addresses,id',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->input('new_address') === 'on') {
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
            'status_id' => 5,
            'total' => $total,
            'payment_method' => 'multibanco',
            'nif' => $nif,
        ]);

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            $quantityToReduce = $details['quantity'];
            if ($product->quantity < $quantityToReduce) {
                $quantityToReduce = $product->quantity;
                $sale->products()->attach($id, [
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                    'quantity_shortage' => $details['quantity'] - $product->quantity,
                ]);
            } else {
                $sale->products()->attach($id, [
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                    'quantity_shortage' => 0,
                ]);
            }

            $product->quantity -= $quantityToReduce;
            $product->save();
        }

        foreach ($packCart as $id => $details) {
            $sale->packs()->attach($id, [
                'quantity' => $details['quantity'],
                'price' => $details['price'],
            ]);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $paymentMethod = PaymentMethod::create([
            'type' => 'multibanco',
            'billing_details' => [
                'email' => Auth::user()->email,
            ],
        ]);

        $paymentIntent = PaymentIntent::create([
            'amount' => $total * 100,
            'currency' => 'eur',
            'payment_method_types' => ['multibanco'],
            'payment_method' => $paymentMethod->id,
            'confirmation_method' => 'automatic',
            'confirm' => true,
        ]);

        $sale->payment_intent_id = $paymentIntent->id;
        $sale->save();

        session()->forget('cart');
        session()->forget('packCart');

        return redirect()->route('sales.show', ['sale' => $sale->id]);
    }

}
