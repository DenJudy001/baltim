<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\DetailPos;
use Illuminate\Http\Request;
use App\Models\FoodNBeverages;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class DetailPosController extends Controller
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
    public function show(DetailPos $detailPos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailPos $detailPos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailPos $detailPos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailPos $detail_po)
    {
        $total = Pos::find($detail_po->pos_id);

        $price = DetailPos::find($detail_po->id);
        $newTotal = $total->total - ($price->price*$price->qty);

        Pos::where('id',$detail_po->pos_id)->update(['total'=>$newTotal]);  

        DetailPos::destroy($detail_po->id);
        
        session()->flash('success', 'Data Penjualan Berhasil Dihapus');
    }

    public function updateDetailPos(Request $request)
    {
        $pos = $request->pos_id;
        $dataPos = Pos::find($pos);
        $dataMenu = FoodNBeverages::where('name',$request->name)->select('type','image')->first();
        if ($request->id){
            $rules = [
                'name' => 'required',
                'qty' => 'required|integer|min:1',
                'price' => 'required|integer|min:1',
            ];

            $validatedDataStuff = $request->validate($rules);
            $validatedDataStuff['description'] = $request->description;
            $validatedDataStuff['type'] = $dataMenu->type;
            $validatedDataStuff['image'] = $dataMenu->image;

            DetailPos::where('id', $request->id)
            ->update($validatedDataStuff);            
            session()->flash('success', 'Berhasil merubah data penjualan');
            // return redirect()->back()->with('success', 'Berhasil merubah data bahan/produk');
            
        }else{
            $rules = [
                'name' => ['required',Rule::unique('detail_pos')->where(function ($query) use ($pos){
                    return $query->where('pos_id', $pos);
                })],
                'qty' => 'required|integer|min:1',
                'price' => 'required|integer|min:1',
            ];

            $validatedDataStuff = $request->validate($rules);
            $validatedDataStuff['description'] = $request->description;
            $validatedDataStuff['type'] = $dataMenu->type;
            $validatedDataStuff['image'] = $dataMenu->image;
            $validatedDataStuff['pos_id'] = $pos;

            DetailPos::create($validatedDataStuff);
            session()->flash('success', 'Berhasil menambahkan data penjualan');
            // return redirect()->back()->with('success', 'Berhasil menambahkan menu ke keranjang');
            
        }

        $totalPrice = DetailPos::where('pos_id', $pos)->sum('price');
        $newTotal = $totalPrice;
        Pos::where('id',$pos)->update(['total'=>$newTotal]);
    }
}
