<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use Illuminate\Http\Request;
use App\Models\FoodNBeverages;
use App\Http\Controllers\Controller;
use App\Models\DetailPos;
use Haruncpi\LaravelIdGenerator\IdGenerator;
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
        $fnbs = FoodNBeverages::when(request('search'), function($query){
            return $query->where('name','like','%'.request('search').'%');
        })->when(request('category_type'), function($query) {
            return $query->where('type', request('category_type'));
        })->orderBy('created_at','desc')->paginate(4);

        $fnbCat = FoodNBeverages::select('type')->distinct()->get();

        return view('dashboard.pos.create', compact('fnbs','fnbCat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataTransaction['purchase_name'] = 'Pemesanan';
        $dataTransaction['responsible'] = auth()->user()->name;
        $dataTransaction['pos_number'] = IdGenerator::generate(['table' => 'pos', 'length' => 10, 'prefix' =>'TRX-','reset_on_prefix_change' => true ,'field' => 'pos_number']);
        $dataTransaction['total'] = $request->totalHarga;
        if($request->state == 'Selesai'){
            $dataTransaction['end_date'] = now();
        }
        $dataTransaction['state'] = $request->state;
        
        $posTransaction = Pos::create($dataTransaction);

        $cart = session()->get('cart');
        foreach ($cart as $menu_id => $details) {
            $dataFnb['pos_id'] = $posTransaction->id;
            $dataFnb['fnb_id'] = $menu_id;
            $dataFnb['qty'] = $details['quantity'];
            $fnb = FoodNBeverages::find($menu_id);
            $dataFnb['name'] = $fnb->name;
            $dataFnb['description'] = $fnb->description;
            $dataFnb['type'] = $fnb->type;
            $dataFnb['image'] = $fnb->image;
            $dataFnb['price'] = $fnb->price;

            DetailPos::create($dataFnb);
        }
        session()->forget('cart');
        
        return redirect('/pos/create')->with('success','Data transaksi penjualan berhasil disimpan! ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pos $po)
    {
        return view('dashboard.pos.show',[
            'pos'=>$po
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pos $po)
    {
        $menus = FoodNBeverages::select('name')->get();
        $categories = FoodNBeverages::select('type')->distinct()->get();

        return view('dashboard.pos.edit',[
            'pos'=>$po,
            'menus'=>$menus,
            'categories'=>$categories
        ]);
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
