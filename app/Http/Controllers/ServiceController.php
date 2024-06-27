<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ServiceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Service::class);
        $services = Service::orderBy('id', 'desc')->paginate(10);

        return view('pages.services.index', ['services' => $services]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $this->authorize('create', Service::class);
        $employees = User::all()->filter(function($user) {
            return $user->hasRole('employee');
        });

        return view('pages.services.create', ['employees' => $employees]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $validatedData = $request->validated();
        Service::create($validatedData);
        return redirect()->route('services.index')->with('Success', 'Service created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $this->authorize('view', $service);
        $users = $service->users;
        return view('pages.services.show', ['service' => $service, 'users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $this->authorize('update', Service::class);
        $employee = User::all()->filter(function($user) {
            return $user->hasRole('employee');
        });

        return view('pages.services.edit', compact('service', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $validatedData = $request->validated();

        $service->update($validatedData);
        return redirect()->route('services.index')->with('Success', 'Servico atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);
        $service->delete();
        return redirect()->route('services.index')->with('Success', 'Servico deleted successfully.');
    }
}
