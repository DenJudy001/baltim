<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DetailPurchase;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
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
        $suppliers = Supplier::all(['id', 'supplier_name']);

        return view('dashboard.purchase.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedDataPurch = $request->validate([
            'supplier_id' => 'required',
            'total' => 'required',
        ]);
        $validatedDataPurch['purchase_name'] = 'Pemesanan';
        $validatedDataPurch['responsible'] = auth()->user()->name;
        $validatedDataPurch['state'] = 'Proses';
        $validatedDataPurch['series_id'] = 1;
        $purchNumber = Purchase::where('series_id', 1)->max('number');
        if($purchNumber !== null){
            $validatedDataPurch['number'] = $purchNumber+1;
            $validatedDataPurch['purchase_number'] = Series::find(1)->series_name. '-' . str_pad($purchNumber+1, 5, '0', STR_PAD_LEFT);
        }else{
            $validatedDataPurch['number'] = 1;
            $validatedDataPurch['purchase_number'] = Series::find(1)->series_name. '-' . str_pad(1, 5, '0', STR_PAD_LEFT);
        }
        
        $purch = Purchase::create($validatedDataPurch);


        if($request->stuff_name){
            $stuff_names = $request->stuff_name;
            $stuff_descs = $request->description;
            $stuff_qtys = $request->qty;
            $stuff_units = $request->unit;
            $stuff_prices = $request->price;
            $stuff_purch = $purch->id;

            $arr_input= [];

            for ($i=0; $i<count($stuff_names); $i++){
                $arr_input[] = [
                    'name' => $stuff_names[$i],
                    'description' => $stuff_descs[$i],
                    'qty' => $stuff_qtys[$i],
                    'unit' => $stuff_units[$i],
                    'price' => $stuff_prices[$i],
                    'purchase_id' => $stuff_purch
                ];
            }

            $validator = Validator::make($arr_input, [
                '*.name' => 'required',
                '*.qty' => 'required|min:1',
                '*.unit' => 'required',
                '*.price' => 'required',
            ]);

            if ($validator->fails()) {
                Purchase::destroy($purch->id);
                return redirect('/purchase/create')->with('error_validate','Gagal! kuantitas minimal 1 ');
            }

            for ($i=0; $i<count($arr_input); $i++){
                DetailPurchase::create([
                    'purchase_id' => $arr_input[$i]['purchase_id'],
                    'name' => $arr_input[$i]['name'],
                    'description' => $arr_input[$i]['description'],
                    'price' => $arr_input[$i]['price'],
                    'qty' => $arr_input[$i]['qty'],
                    'unit' => $arr_input[$i]['unit'],
                ]);
            }
        }
        
        
        return redirect('/supplier')->with('success','Data pemesanan berhasil ditambahkan! ');
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
