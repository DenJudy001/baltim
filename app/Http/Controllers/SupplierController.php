<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Stuff;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.supplier.index', [
            'suppliers'=>Supplier::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.supplier.create', [
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validatedDataSupp = $request->validate([
            'supplier_name' => 'required|min:3|max:255|unique:suppliers',
            'address' => 'required',
            'responsible' => 'required|min:3|max:255',
            'telp' => 'required|min:3|max:255',
        ]);
        $validatedDataSupp['description'] = $request->supplier_description;
        
        $supp = Supplier::create($validatedDataSupp);


        $stuff_names = $request->stuff_name;
        $stuff_descs = $request->description;
        $stuff_prices = $request->price;
        $stuff_supp = $supp->id;

        $arr_input= [];

        for ($i=0; $i<count($stuff_names); $i++){
            $arr_input[] = [
                'stuff_name' => $stuff_names[$i],
                'description' => $stuff_descs[$i],
                'price' => $stuff_prices[$i],
                'supplier_id' => $stuff_supp
            ];
        }

        $validator = Validator::make($arr_input, [
            '*.stuff_name' => 'required',
            '*.price' => 'required',
        ]);

        if ($validator->fails()) {
            Supplier::destroy($supp->id);
            return redirect('/supplier/create')->with('error_validate','Gagal! Nama dan Harga Barang harus dimasukan ');
        }

        for ($i=0; $i<count($arr_input); $i++){
            Stuff::create([
                'supplier_id' => $arr_input[$i]['supplier_id'],
                'stuff_name' => $arr_input[$i]['stuff_name'],
                'description' => $arr_input[$i]['description'],
                'price' => $arr_input[$i]['price']
            ]);
        }
        
        
        return redirect('/supplier')->with('success','Pemasok Baru berhasil ditambahkan! ');
        // return (dd($ddd));
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
