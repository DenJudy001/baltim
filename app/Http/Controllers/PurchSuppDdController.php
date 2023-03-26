<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchSuppDdController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $supplier = Supplier::findOrFail($request->id);
        $stuffFiltered = $supplier->stuff->pluck('stuff_name');
        return response()->json($stuffFiltered);
    }
}
