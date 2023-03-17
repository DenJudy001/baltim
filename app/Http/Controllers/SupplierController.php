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
            '*.stuff_name' => 'required|unique:stuffs',
            '*.price' => 'required',
        ]);

        if ($validator->fails()) {
            Supplier::destroy($supp->id);
            return redirect('/supplier/create')->with('error_validate','Gagal! nama barang tidak boleh sama ');
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


        $stuffs = $supplier->stuff->toArray();
        $arr_input= [];
        $arr_input_newOrUpdate= [];
        // $arr_del = [];
        $stuff_id = $request->stuff_id;
        $stuff_names = $request->stuff_name;
        $stuff_descs = $request->description;
        $stuff_prices = $request->price;

        for ($i=0; $i<count($stuff_names); $i++){
            if(isset($stuffs[$i]['stuff_name'])){
                //bisa pakai if stuff_id di db not in array dari stuff_id di request, maka $i ubah jdi $val = $i + 1,
                // terus push ke arr_del
                if($stuffs[$i]['stuff_name'] != $stuff_names[$i]){
                    $arr_input_newOrUpdate[] = [
                        'id' => $stuff_id[$i],
                        'stuff_name' => $stuff_names[$i],
                        'description' => $stuff_descs[$i],
                        'price' => $stuff_prices[$i],
                    ];
                    
                } 
                else {
                    $arr_input[] = [
                        'id' => $stuff_id[$i],
                        'description' => $stuff_descs[$i],
                        'price' => $stuff_prices[$i],
                    ];
                }
            } 
            else {
                $arr_input_newOrUpdate[] = [
                    'id' => '',
                    'stuff_name' => $stuff_names[$i],
                    'description' => $stuff_descs[$i],
                    'price' => $stuff_prices[$i],
                ];
            } 
        }
        
        $stuffNames = array_column($arr_input_newOrUpdate, 'stuff_name');
        
        if (count($stuffNames) !== count(array_unique($stuffNames))){
            return redirect('/supplier/'.$supplier->id.'/edit')->with('error_validate','Gagal! nama barang tidak boleh sama ');
        }

        $validator_newOrCreate = Validator::make($arr_input_newOrUpdate, [
            '*.stuff_name' => 'required|unique:stuffs',
            '*.price' => 'required',
        ]);
        
        $validator = Validator::make($arr_input, [
            '*.price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/supplier/'.$supplier->id.'/edit')->with('error_validate','Gagal! kolom harga tidak boleh kosong ');
        }
        if ($validator_newOrCreate->fails()) {
            return redirect('/supplier/'.$supplier->id.'/edit')->with('error_validate','Gagal! nama barang tidak boleh sama ');
        }

        
        if(count($arr_input) > 0){
            for ($i=0; $i<count($arr_input); $i++){
                Stuff::updateOrCreate(
                    ['id' => $arr_input[$i]['id']],
                    [
                        'description' => $arr_input[$i]['description'],
                        'price' => $arr_input[$i]['price']
                    ]);
            }
        }

        if(count($arr_input_newOrUpdate) > 0){
            for ($i=0; $i<count($arr_input_newOrUpdate); $i++){
                Stuff::updateOrCreate(
                    ['id' => $arr_input_newOrUpdate[$i]['id']],
                    [
                        'supplier_id' => $supplier->id,
                        'stuff_name' => $arr_input_newOrUpdate[$i]['stuff_name'],
                        'description' => $arr_input_newOrUpdate[$i]['description'],
                        'price' => $arr_input_newOrUpdate[$i]['price']
                    ]);
            }
        }


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
}
