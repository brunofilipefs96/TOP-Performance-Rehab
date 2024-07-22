<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Insurance;
use App\Http\Requests\StoreInsuranceRequest;
use App\Http\Requests\UpdateFreeTrainingRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class InsuranceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Insurance::class);

        $search = request('search');
        $filter = request('filter', 'all'); // Default to 'all' if filter is not provided

        $query = Insurance::query();

        if ($search) {
            $search = strtolower($search);
            $query->where(function($q) use ($search) {
                $q->whereHas('membership.user', function($q) use ($search) {
                    $q->whereRaw('LOWER(full_name) LIKE ?', ['%' . $search . '%'])
                        ->orWhereRaw('LOWER(nif) LIKE ?', ['%' . $search . '%']);
                })->orWhereHas('status', function($q) use ($search) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);
                });
            });
        }

        if ($filter && $filter !== 'all') {
            $query->whereHas('status', function ($q) use ($filter) {
                if ($filter === 'pending') {
                    $q->whereIn('name', ['pending', 'renew_pending']);
                } elseif ($filter === 'pending_payment') {
                    $q->whereIn('name', ['pending_payment', 'pending_renewPayment']);
                } else {
                    $q->whereRaw('LOWER(name) = ?', [strtolower($filter)]);
                }
            });
        }

        $insurances = $query->orderBy('id', 'desc')->paginate(12);

        return view('pages.insurances.index', ['insurances' => $insurances]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Insurance::class);
        return view('pages.insurances.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInsuranceRequest $request)
    {
        $user = auth()->user();
        $membership = $user->membership;

        if ($membership && !$membership->insurance) {
            $insurance = Insurance::create([
                'membership_id' => $membership->id,
                'status_id' => Status::where('name', 'pending')->firstOrFail()->id,
                'insurance_type' => $request->insurance_type,
                'start_date' => $request->start_date ?? now(),
                'end_date' => $request->end_date ?? now()->addYear(),
            ]);

            return redirect()->route('setup.awaitingShow')->with('success', 'Insurance Created!');
        }

        return redirect()->route('setup.awaitingShow')->with('error', 'Já possui um seguro.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Insurance $insurance)
    {
        $this->authorize('view', $insurance);
        return view('pages.insurances.show', ['insurance' => $insurance]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insurance $insurance)
    {
        $this->authorize('update', $insurance);
        return view('pages.insurances.edit', ['insurance' => $insurance]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFreeTrainingRequest $request, Insurance $insurance)
    {
        $this->authorize('update', $insurance);

        $status = Status::where('name', $request->input('status_name'))->firstOrFail();

        if($insurance->status->name == 'pending'){
            $insurance->status_id = $status->id;
        }

        if($insurance->status->name == 'renew_pending'){
            $insurance->status_id = $status->id;
        }

        if($insurance->status->name == 'active') {
            $insurance->start_date = now();
            $insurance->end_date = now()->addYear();
        }

        $insurance->save();

        return redirect()->route('insurances.show', ['insurance' => $insurance])->with('success', 'Insurance Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insurance $insurance)
    {
        $this->authorize('delete', $insurance);

        $insurance->delete();

        return Redirect::back()->with('success', 'Insurance Deleted!');
    }

    public function addDocument(Request $request, Insurance $insurance)
    {
        $this->authorize('update', $insurance);

        $request->validate([
            'documents.*' => 'required|file|mimes:pdf,jpg,png,doc,docx|max:2048'
        ]);

        try {
            foreach ($request->file('documents') as $file) {
                $filename = "{$insurance->id}_{$file->getClientOriginalName()}";
                $path = $file->storeAs("public/documents/insurances/{$insurance->id}", $filename);

                $document = new Document();
                $document->name = $filename;
                $document->file_path = $path;
                $document->save();

                $insurance->documents()->attach($document->id);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function deleteDocument(Insurance $insurance, Document $document)
    {
        $this->authorize('delete', $insurance);

        try {
            $insurance->documents()->detach($document->id);
            Storage::delete($document->file_path);
            $document->delete();

            // Remove the directory if it is empty
            $directory = "public/documents/insurances/{$insurance->id}";
            if (Storage::files($directory) == []) {
                Storage::deleteDirectory($directory);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

}
