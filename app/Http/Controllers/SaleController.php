<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Sale::class);

        $status = $request->input('status', 'all');
        $nif = $request->input('nif', '');

        $query = Sale::query();

        if ($status !== 'all') {
            $query->whereHas('status', function ($query) use ($status) {
                $query->where('name', $status);
            });
        }

        if ($nif) {
            $query->where('nif', 'like', '%' . $nif . '%');
        }

        $query->orderBy('created_at', 'desc');

        $sales = $query->paginate(12);

        return view('pages.sales.index', ['sales' => $sales, 'status' => $status, 'nif' => $nif]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $this->authorize('view', $sale);

        return view('pages.sales.show', ['sale' => $sale]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
