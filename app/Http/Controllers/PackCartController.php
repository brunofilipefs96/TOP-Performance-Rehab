<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PackCartController extends Controller
{
    public function removeFromCart($id)
    {
        $packCart = session()->get('packCart', []);

        if(isset($packCart[$id])) {
            unset($packCart[$id]);
        }

        session()->put('packCart', $packCart);

        return redirect()->route('cart.index')->with('success', 'Pack removido do carrinho!');
    }
}
