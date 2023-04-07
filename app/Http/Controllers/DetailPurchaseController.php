<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Models\DetailPurchase;
use App\Http\Controllers\Controller;

class DetailPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailPurchase $detailPurchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailPurchase $detailPurchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailPurchase $detail_purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailPurchase $detail_purchase)
    {
        $total = Purchase::find($detail_purchase->purchase_id);

        $price = DetailPurchase::find($detail_purchase->id);
        $newTotal = $total->total - ($price->price*$price->qty);

        Purchase::where('id',$detail_purchase->purchase_id)->update(['total'=>$newTotal]);  

        DetailPurchase::destroy($detail_purchase->id);
        
        session()->flash('success', 'Data Barang Berhasil Dihapus');
    }

    public function updateDetailPurchase(Request $request)
    {
        $purchase = $request->purchase_id;
        $dataPurch = Purchase::find($purchase);
        if ($request->id){
            $rules = [
                'name' => 'required',
                'qty' => 'required|integer|min:1',
                'unit' => 'required',
                'price' => 'required|integer|min:1',
            ];

            $validatedDataStuff = $request->validate($rules);
            $validatedDataStuff['description'] = $request->description;

            DetailPurchase::where('id', $request->id)
            ->update($validatedDataStuff);            
            session()->flash('success', 'Berhasil merubah data bahan/produk');
            // return redirect()->back()->with('success', 'Berhasil merubah data bahan/produk');
            
        }else{
            $rules = [
                'name' => 'required',
                'qty' => 'required|integer|min:1',
                'unit' => 'required',
                'price' => 'required|integer|min:1',
            ];

            $validatedDataStuff = $request->validate($rules);
            $validatedDataStuff['description'] = $request->description;
            $validatedDataStuff['purchase_id'] = $purchase;

            DetailPurchase::create($validatedDataStuff);
            session()->flash('success', 'Berhasil menambahkan data bahan/produk');
            // return redirect()->back()->with('success', 'Berhasil menambahkan menu ke keranjang');
            
        }

        $stuffData = Stuff::where('supplier_id',$dataPurch->supplier_id)->pluck('stuff_name')->toArray();

        if (in_array($request->name, $stuffData)) {
            // 
        } else {
            Stuff::create([
                'supplier_id' => $dataPurch->supplier_id,
                'stuff_name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
            ]);
        }

        $newTotal = $dataPurch->total + ($request->price*$request->qty);
        Purchase::where('id',$purchase)->update(['total'=>$newTotal]);
    }
}
