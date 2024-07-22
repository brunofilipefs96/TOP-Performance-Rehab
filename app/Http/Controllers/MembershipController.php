<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Insurance;
use App\Models\Membership;
use App\Http\Requests\StoreMembershipRequest;
use App\Http\Requests\UpdateMembershipRequest;
use App\Models\Notification;
use App\Models\NotificationType;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use MattDaneshvar\Survey\Models\Entry;
use MattDaneshvar\Survey\Models\Survey;

class MembershipController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Membership::class);

        $search = request('search');
        $filter = request('filter', 'all'); // Default to 'all' if filter is not provided

        $query = Membership::query();

        if ($search) {
            $search = strtolower($search);
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q) use ($search) {
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

        $memberships = $query->orderBy('id', 'desc')->paginate(12);

        return view('pages.memberships.index', ['memberships' => $memberships]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->authorize('create', Membership::class);

        $addresses = auth()->user()->addresses;

        return view('pages.memberships.create', ['addresses' => $addresses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMembershipRequest $request)
    {
        $user = auth()->user();

        if ($user->hasRole('client') && !$user->membership) {
            if (!$user->cc_number && $request->has('cc_number')) {
                $user->cc_number = $request->input('cc_number');
                $user->save();
            }

            $membership = Membership::create([
                'user_id' => $user->id,
                'address_id' => $request->input('address_id'),
            ]);

            return redirect()->route('setup.trainingTypesShow')->with('success', 'Matrícula criada com sucesso!');
        }

        return redirect()->route('setup.trainingTypesShow')->with('error', 'Já possui uma matrícula.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Membership $membership)
    {
        $this->authorize('view', $membership);

        return view('pages.memberships.show', ['membership' => $membership]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMembershipRequest $request, Membership $membership)
    {
        $this->authorize('update', $membership);

        $status = Status::where('name', $request->input('status_name'))->firstOrFail();
        $notificationType = null;
        $notificationMessage = '';
        $url = 'memberships/' . $membership->id;

        if ($status->name == 'pending_payment') {
            $membership->status_id = $status->id;
            $membership->save();

            $notificationType = NotificationType::where('name', 'Matrícula Aprovada')->firstOrFail();
            $notificationMessage = 'A sua matrícula foi aprovada e aguarda pagamento.';
        } elseif ($status->name == 'pending_renewPayment') {
            $membership->status_id = $status->id;
            $membership->save();

            $notificationType = NotificationType::where('name', 'Renovação Aprovada')->firstOrFail();
            $notificationMessage = 'A sua renovação foi aprovada e aguarda pagamento.';
        } elseif ($status->name == 'rejected') {
            $membership->status_id = $status->id;
            $membership->save();

            $notificationType = NotificationType::where('name', 'Matrícula Negada')->firstOrFail();
            $notificationMessage = 'A sua matrícula foi rejeitada.';
        } elseif ($status->name == 'frozen') {
            $membership->status_id = $status->id;
            $membership->save();

            $notificationType = NotificationType::where('name', 'Matrícula Congelada')->firstOrFail();
            $notificationMessage = 'A sua matrícula foi congelada.';
        } else {
            $membership->status_id = $status->id;
            $membership->save();
        }

        if ($notificationType) {
            $notification = Notification::create([
                'notification_type_id' => $notificationType->id,
                'message' => $notificationMessage,
                'url' => $url,
            ]);

            $user = $membership->user;
            $user->notifications()->attach($notification->id);
        }

        return redirect()->route('memberships.show', ['membership' => $membership])->with('success', 'Membership Updated!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Membership $membership)
    {
        $this->authorize('delete', $membership);
        $entry = $membership->user->entries->first();
        $entry->delete();
        $insurance = $membership->insurance;
        $insurance->delete();
        $membership->delete();
        return redirect()->route('memberships.index')->with('success', 'Membership Deleted!');
    }

    public function form(Request $request)
    {
        $this->authorize('form', Membership::class);

        $entries = Entry::find($request->entry)->questions;

        return view('pages.memberships.form', ['entries' => $entries]);
    }

    public function addDocument(Request $request, Membership $membership)
    {
        $this->authorize('update', $membership);

        $request->validate([
            'documents.*' => 'required|file|mimes:pdf,jpg,png,doc,docx|max:2048'
        ]);

        try {
            foreach ($request->file('documents') as $file) {
                $filename = "{$membership->id}_{$file->getClientOriginalName()}";
                $path = $file->storeAs("public/documents/memberships/{$membership->id}", $filename);

                $document = new Document();
                $document->name = $filename;
                $document->file_path = $path;
                $document->save();

                $membership->documents()->attach($document->id);
            }

            return redirect()->back()->with('success', 'Documentos adicionados com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao adicionar documentos.');
        }
    }

    public function deleteDocument(Membership $membership, Document $document)
    {
        $this->authorize('delete', $membership);

        try {
            $membership->documents()->detach($document->id);
            Storage::delete($document->file_path);
            $document->delete();

            $directory = "public/documents/memberships/{$membership->id}";
            if (count(Storage::files($directory)) === 0) {
                Storage::deleteDirectory($directory);
            }

            return redirect()->back()->with('success', 'Documento removido com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao remover documento.');
        }
    }

}
