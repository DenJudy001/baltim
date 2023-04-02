<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Http\Controllers\Controller;
use App\Models\FoodNBeverages;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class PosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fnbs = FoodNBeverages::orderBy('created_at','desc')->paginate(4);
        return view('dashboard.pos.create', compact('fnbs'));
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
    public function show(Pos $pos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pos $pos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pos $pos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pos $pos)
    {
        //
    }
    
    public function addToCart($menu)
    {
        $menuData = FoodNBeverages::findOrFail($menu);
          
        $cart = session()->get('cart', []);
  
        if(isset($cart[$menu])) {
            $cart[$menu]['quantity']++;
        } else {
            $cart[$menu] = [
                "name" => $menuData->name,
                "quantity" => 1,
                "price" => $menuData->price,
                "image" => $menuData->image
            ];
        }
          
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Berhasil menambahkan menu ke keranjang');
    }

    public function updateQty(Request $request)
    {
        // dd($request);
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Berhasil merubah jumlah');
        }
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Berhasil menghapus keranjang menu');
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
    }
}
