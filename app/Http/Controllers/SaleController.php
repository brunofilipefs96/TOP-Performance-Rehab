<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SaleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Sale::class);

        $sales = Sale::all();

        return view('pages.sales.index', ['sales' => $sales]);
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
