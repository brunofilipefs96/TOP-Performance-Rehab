<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Http\Requests\StorePackRequest;
use App\Http\Requests\UpdatePackRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
}
