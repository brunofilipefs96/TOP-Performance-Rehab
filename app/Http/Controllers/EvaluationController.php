<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Evaluation;
use App\Http\Requests\StoreEvaluationRequest;
use App\Models\Membership;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvaluationController extends Controller
{
    use AuthorizesRequests;

    public function create(Membership $membership)
    {
        $this->authorize('create', Evaluation::class);
        return view('pages.evaluations.create', ['membership' => $membership]);
    }

    public function store(StoreEvaluationRequest $request, Membership $membership)
    {
        $this->authorize('create', Evaluation::class);

        $validatedData = $request->validated();
        $validatedData['observations'] = $validatedData['observations'] ?? '';

        $evaluation = $membership->evaluations()->create($validatedData);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $filename = "{$evaluation->id}_{$file->getClientOriginalName()}";
                $path = $file->storeAs("public/evaluations/{$evaluation->id}", $filename);

                $document = new Document();
                $document->name = $filename;
                $document->file_path = $path;
                $document->save();

                $evaluation->documents()->attach($document->id);
            }
        }

        return response()->json([
            'success' => true,
            'redirect' => route('memberships.evaluations.list', ['membership' => $membership->id])
        ]);
    }



    private function addDocumentsToEvaluation(Request $request, Evaluation $evaluation)
    {
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $filename = "{$evaluation->id}_{$file->getClientOriginalName()}";
                $path = $file->storeAs("public/evaluations/{$evaluation->id}", $filename);

                $document = new Document();
                $document->name = $filename;
                $document->file_path = $path;
                $document->save();

                $evaluation->documents()->attach($document->id);
            }
        }
    }

    public function addDocument(Request $request, $evaluationId)
    {
        $evaluation = Evaluation::findOrFail($evaluationId);

        $this->addDocumentsToEvaluation($request, $evaluation);

        return response()->json(['success' => true]);
    }

    public function show(Membership $membership, Evaluation $evaluation)
    {
        $this->authorize('view', $evaluation);
        return view('pages.evaluations.show', ['evaluation' => $evaluation, 'membership' => $membership]);
    }

    public function destroy(Membership $membership, Evaluation $evaluation)
    {
        $this->authorize('delete', $evaluation);

        if($evaluation->documents())
        foreach ($evaluation->documents as $document) {
            Storage::delete($document->file_path);
            $document->delete();
        }

        $evaluation->delete();
        return redirect()->route('memberships.evaluations.list', ['membership' => $evaluation->membership_id])
            ->with('success', 'Avaliação eliminada com sucesso!');
    }

    public function listForMembership(Membership $membership)
    {
        $this->authorize('viewAny', Evaluation::class);

        if ($membership->status->name == 'active') {
            $evaluations = $membership->evaluations()->orderBy('created_at', 'desc')->paginate(12);
            return view('pages.evaluations.list', ['evaluations' => $evaluations, 'membership' => $membership]);
        }
        return redirect('memberships/'.$membership->id);
    }

    public function deleteDocument($evaluationId, $documentId)
    {
        $evaluation = Evaluation::findOrFail($evaluationId);
        $document = Document::findOrFail($documentId);

        Storage::delete($document->file_path);
        $evaluation->documents()->detach($document->id);
        $document->delete();

        return response()->json(['success' => true]);
    }
}
