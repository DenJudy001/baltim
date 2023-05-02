<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class OtherPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect("/otherpurchase/create");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.otherPurchase.create', [
            'title'=>"Pembayaran",
            'purchaseName'=>Purchase::select('purchase_name')->distinct()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request ->validate([
            'purchase_name' => 'required',
            'total' => 'required',
        ]);

        $validatedData['purchase_name'] = ucwords($request->purchase_name);
        $validatedData['description'] = $request->supplier_description;
        $validatedData['responsible'] = auth()->user()->username;
        $validatedData['state'] = 'Selesai';
        $validatedData['end_date'] = now();
        $validatedData['purchase_number'] = IdGenerator::generate(['table' => 'purchases', 'length' => 10, 'prefix' =>'PUR-','reset_on_prefix_change' => true ,'field' => 'purchase_number']);

        Purchase::create($validatedData);
        return redirect('/account')->with('success','Berhasil Membuat Catatan Pembayaran');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
