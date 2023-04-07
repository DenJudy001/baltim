<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

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


        if($request->stuff_name){
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
                '*.stuff_name' => 'required|min:2',
                '*.price' => 'required',
            ]);


            if ($validator->fails()) {
                Supplier::destroy($supp->id);

                $stuffNames = array_column($arr_input, 'stuff_name');
    
                if (count($stuffNames) !== count(array_unique($stuffNames))){
                    return redirect()->back()->with('error_validate','Gagal! nama barang tidak boleh sama ')->withErrors($validator->errors())->withInput();
                }
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else{
                $stuffNames = array_column($arr_input, 'stuff_name');
    
                if (count($stuffNames) !== count(array_unique($stuffNames))){
                    return redirect()->back()->with('error_unique','Gagal! nama barang tidak boleh sama ')->withInput();
                }
            }


            for ($i=0; $i<count($arr_input); $i++){
                Stuff::create([
                    'supplier_id' => $arr_input[$i]['supplier_id'],
                    'stuff_name' => $arr_input[$i]['stuff_name'],
                    'description' => $arr_input[$i]['description'],
                    'price' => $arr_input[$i]['price']
                ]);
            }
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
        return view('dashboard.supplier.edit',[
            'supplier' => $supplier,
            'stuffs' => $supplier->stuff
            // 'stuffs' => Supplier::find($supplier->id)->stuff
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $rules = [
            'address' => 'required',
            'responsible' => 'required|min:3|max:255',
            'telp' => 'required|min:3|max:255',
        ];
        
        if($request->supplier_name != $supplier->supplier_name) {
            $rules['supplier_name'] = 'required|min:3|max:255|unique:suppliers';
        }

        $validatedDataSupp = $request->validate($rules);
        $validatedDataSupp['description'] = $request->supplier_description;

        Supplier::where('id',$supplier->id)->update($validatedDataSupp);

        return redirect('/supplier')->with('success','Data pemasok berhasil diubah! ');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        Supplier::destroy($supplier->id);

        return redirect('/supplier')->with('success','Data Pemasok Berhasil Dihapus ');
    }

    public function updateStuff(Request $request)
    {
        $supplier = $request->supplier_id;
        if ($request->id){
            $stuffs = Stuff::find($request->id);
            $rules = [
                'price' => 'required|integer|min:1',
            ];
            
            if($request->stuff_name != $stuffs->stuff_name) {
                $rules['stuff_name'] = ['required',Rule::unique('stuffs')->where(function ($query) use ($supplier){
                    return $query->where('supplier_id', $supplier);
                })];
            }
    
            $validatedDataStuff = $request->validate($rules);
            $validatedDataStuff['description'] = $request->description;

            Stuff::where('id', $request->id)
            ->update($validatedDataStuff);
            session()->flash('success', 'Berhasil merubah data bahan/produk');
            // return redirect()->back()->with('success', 'Berhasil merubah data bahan/produk');
            
        }else{
            $rules = [
                'price' => 'required|integer|min:1',
                'stuff_name' => ['required',Rule::unique('stuffs')->where(function ($query) use ($supplier){
                    return $query->where('supplier_id', $supplier);
                })],
            ];

            $validatedDataStuff = $request->validate($rules);
            $validatedDataStuff['description'] = $request->description;
            $validatedDataStuff['supplier_id'] = $supplier;

            Stuff::create($validatedDataStuff);
            session()->flash('success', 'Berhasil menambahkan data bahan/produk');
            // return redirect()->back()->with('success', 'Berhasil menambahkan menu ke keranjang');
            
        }
    }
}
