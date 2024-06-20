<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Http\Requests\StorePackRequest;
use App\Http\Requests\UpdatePackRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PackController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Pack::class);
        $packs = Pack::orderBy('id', 'desc')->paginate(10);
        return view('pages.packs.index', ['packs' => $packs]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Pack::class);
        return view('pages.packs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackRequest $request)
    {
        $validatedData = $request->validated();

        Pack::create($validatedData);

        return redirect()->route('packs.index')->with('success', 'Pack created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pack $pack)
    {
        $this->authorize('view', $pack);
        return view('pages.packs.show', ['pack' => $pack]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pack $pack)
    {
        $this->authorize('update', $pack);
        return view('pages.packs.edit', ['pack' => $pack]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackRequest $request, Pack $pack)
    {
        $validatedData = $request->validated();

        $pack->update($validatedData);

        return redirect()->route('packs.index')->with('success', 'Pack updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pack $pack)
    {
        $this->authorize('delete', $pack);
        $pack->delete();
        return redirect()->route('packs.index')->with('success', 'Pack deleted successfully.');
    }

    public function addToCart(Request $request)
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
            $packCart[$packId]['quantity']++;
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

}
