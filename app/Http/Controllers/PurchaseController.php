<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use App\Models\Series;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\DetailPurchase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect("/purchase/create");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all(['id', 'supplier_name']);
        $title = "Pemesanan";

        return view('dashboard.purchase.create', compact('suppliers','title'));
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
        $validatedDataPurch['purchase_name'] = 'Persediaan Bahan';
        $validatedDataPurch['responsible'] = auth()->user()->username;
        $validatedDataPurch['state'] = 'Proses';
        $validatedDataPurch['purchase_number'] = IdGenerator::generate(['table' => 'purchases', 'length' => 10, 'prefix' =>'PUR-','reset_on_prefix_change' => true ,'field' => 'purchase_number']);
        $dataSupplier = Supplier::where('id', $request->supplier_id)->first();

        $validatedDataPurch['supplier_name'] = $dataSupplier->supplier_name;
        $validatedDataPurch['description'] = $dataSupplier->description;
        $validatedDataPurch['address'] = $dataSupplier->address;
        $validatedDataPurch['supplier_responsible'] = $dataSupplier->responsible;
        $validatedDataPurch['telp'] = $dataSupplier->telp;
        
        $purch = Purchase::create($validatedDataPurch);


        if($request->stuff_name){
            $stuff_names = $request->stuff_name;
            $stuff_descs = $request->description;
            $stuff_qtys = $request->qty;
            $stuff_units = $request->unit;
            $stuff_prices = $request->price;
            $stuff_purch = $purch->id;

            $arr_input= [];
            $stuff_input= [];

            $stuffData = Stuff::where('supplier_id',$request->supplier_id)->pluck('stuff_name')->toArray();

            for ($i=0; $i<count($stuff_names); $i++){
                $arr_input[] = [
                    'name' => $stuff_names[$i],
                    'description' => $stuff_descs[$i],
                    'qty' => $stuff_qtys[$i],
                    'unit' => $stuff_units[$i],
                    'price' => $stuff_prices[$i],
                    'purchase_id' => $stuff_purch
                ];
                if (in_array($stuff_names[$i], $stuffData)) {
                    // 
                } else {
                    $stuff_input[] = [
                        'stuff_name' => $stuff_names[$i],
                        'description' => $stuff_descs[$i],
                        'price' => $stuff_prices[$i],
                        'supplier_id' => $request->supplier_id
                    ];
                }
            }

            $validator = Validator::make($arr_input, [
                '*.name' => 'required',
                '*.qty' => 'required|integer|min:1',
                '*.unit' => 'required',
                '*.price' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                Purchase::destroy($purch->id);
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }

            for ($i=0; $i<count($arr_input); $i++){
                DetailPurchase::create([
                    'purchase_id' => $arr_input[$i]['purchase_id'],
                    'name' => $arr_input[$i]['name'],
                    'description' => $arr_input[$i]['description'],
                    'price' => $arr_input[$i]['price']*$arr_input[$i]['qty'],
                    'qty' => $arr_input[$i]['qty'],
                    'unit' => $arr_input[$i]['unit'],
                ]);
            }

            if(count($stuff_input) > 0){
                for ($i=0; $i<count($stuff_input); $i++){
                    Stuff::create([
                        'supplier_id' => $stuff_input[$i]['supplier_id'],
                        'stuff_name' => $stuff_input[$i]['stuff_name'],
                        'description' => $stuff_input[$i]['description'],
                        'price' => $stuff_input[$i]['price'],
                    ]);
                }
            }
        }
        
        
        return redirect('/transactions')->with('success','Transaksi Pemesanan Berhasil Ditambahkan! ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return view('dashboard.purchase.show',[
            'purchase'=>$purchase,
            'title'=>"Info Pemesanan"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        $stuffs = Stuff::where('supplier_id',$purchase->supplier_id)->select('stuff_name')->get();

        $suppData = Supplier::pluck('id')->toArray();
        $checkMenu = False;

        if (in_array($purchase->supplier_id, $suppData)) {
            // 
        }else{
            $checkMenu = True;
        }

        if ($purchase->state == 'Proses' && $checkMenu != True){
            return view('dashboard.purchase.edit',[
                'purchase'=>$purchase,
                'stuffs'=>$stuffs,
                'title'=>"Info Pemesanan"
            ]);
        } else {
            if ($checkMenu == True && $purchase->state == 'Proses'){
                return view('dashboard.purchase.editlock',[
                    'purchase'=>$purchase,
                    'check_menu'=>$checkMenu,
                    'announce' => 'Rincian pemesanan tidak dapat diubah karena pemasok tidak terdaftar atau terhapus',
                    'title'=>"Ubah Data Pemesanan"
                ]);
            } else if (count($purchase->dtl_purchase) != null){
                return view('dashboard.purchase.editlock',[
                    'purchase'=>$purchase,
                    'check_menu'=>$checkMenu,
                    'announce' => 'Rincian pemesanan tidak dapat diubah karena status transaksi telah '.$purchase->state.'',
                    'title'=>"Ubah Data Pemesanan"
                ]);
            }else{
                return view('dashboard.purchase.editlock',[
                    'purchase'=>$purchase,
                    'check_menu'=>$checkMenu,
                    'announce' => 'Rincian pembayaran tidak dapat diubah karena status transaksi telah '.$purchase->state.'',
                    'title'=>"Ubah Data Pembayaran"
                ]);
            }
        }
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
        Purchase::destroy($purchase->id);

        session()->flash('success', 'Transaksi Berhasil Dihapus');
    }

    public function updateStatus(Request $request)
    {
        $endDate = now();
        $endBy = auth()->user()->username;
        $newStatus = $request->state;
        Purchase::where('id', $request->purchase_id)
            ->update(['state'=>$newStatus, 'end_date'=>$endDate,'end_by'=>$endBy]);  
        
        session()->flash('success', 'Berhasil Merubah Status Pemesanan');   
    }
}
