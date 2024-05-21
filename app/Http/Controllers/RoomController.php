<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoomController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Room::class);
        $rooms = Room::orderBy('id', 'desc')->paginate(10);
        return view('pages.rooms.index', ['rooms' => $rooms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Room::class);
        return view('pages.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        $validatedData = $request->validated();

        Room::create($validatedData);
        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $this->authorize('view', $room);
        return view('pages.rooms.show', ['room' => $room]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $this->authorize('update', $room);
        return view('pages.rooms.edit', ['room' => $room]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $validatedData = $request->validated();
        $room->update($validatedData);
        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $this->authorize('delete', $room);
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}
