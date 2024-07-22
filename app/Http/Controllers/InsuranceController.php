<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Insurance;
use App\Http\Requests\StoreInsuranceRequest;
use App\Http\Requests\UpdateFreeTrainingRequest;
use App\Models\Notification;
use App\Models\NotificationType;
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
        $notificationType = null;
        $notificationMessage = '';
        $url = 'insurances/' . $insurance->id;

        if ($status->name == 'pending_payment') {
            $insurance->status_id = $status->id;
            $insurance->save();

            if ($insurance->insurance_type === 'pessoal') {
                $notificationType = NotificationType::where('name', 'Seguro Aprovado')->firstOrFail();
                $notificationMessage = 'O seu seguro foi aprovado.';
            } else {
                $notificationType = NotificationType::where('name', 'Seguro Aprovado')->firstOrFail();
                $notificationMessage = 'O seu seguro foi aprovado e aguarda pagamento.';
            }
        } elseif ($status->name == 'pending_renewPayment') {
            $insurance->status_id = $status->id;
            $insurance->save();

            if ($insurance->insurance_type === 'pessoal') {
                $notificationType = NotificationType::where('name', 'Renovação Aprovada')->firstOrFail();
                $notificationMessage = 'A sua renovação de seguro foi aprovada.';
            } else {
                $notificationType = NotificationType::where('name', 'Renovação Aprovada')->firstOrFail();
                $notificationMessage = 'A sua renovação de seguro foi aprovada e aguarda pagamento.';
            }
        } elseif ($status->name == 'rejected') {
            $insurance->status_id = $status->id;
            $insurance->save();

            $notificationType = NotificationType::where('name', 'Seguro Negado')->firstOrFail();
            $notificationMessage = 'O seu seguro foi rejeitado.';
        } elseif ($status->name == 'frozen') {
            $insurance->status_id = $status->id;
            $insurance->save();

            $notificationType = NotificationType::where('name', 'Seguro Congelado')->firstOrFail();
            $notificationMessage = 'O seu seguro foi congelado.';
        } elseif ($status->name == 'active') {
            $insurance->start_date = now();
            $insurance->end_date = now()->addYear();
            $insurance->status_id = $status->id;
            $insurance->save();

            $notificationType = NotificationType::where('name', 'Seguro Aprovado')->firstOrFail();
            $notificationMessage = 'O seu seguro foi ativado.';
        } else {
            $insurance->status_id = $status->id;
            $insurance->save();
        }

        if ($notificationType) {
            $notification = Notification::create([
                'notification_type_id' => $notificationType->id,
                'message' => $notificationMessage,
                'url' => $url,
            ]);

            $user = $insurance->membership->user;
            $user->notifications()->attach($notification->id);
        }

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
