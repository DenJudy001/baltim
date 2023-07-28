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
       return redirect("/pos/create");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $fnbs = FoodNBeverages::when(request('search'), function($query){
            $query->where(function($query){
                $query->where('name', 'like', '%' . request('search') . '%')
                      ->orWhere('code', 'like', '%' . request('search') . '%');
            });
        })
        ->when(request('category_type'), function($query) {
            return $query->where('type', request('category_type'));
        })
        ->orderBy('created_at','desc')
        ->simplePaginate(6);

        $fnbCat = FoodNBeverages::select('type')->distinct()->get();
        $title = "Penjualan";

        if($request->ajax()){
            return view('dashboard.pos.menu', compact('fnbs','fnbCat','title'))->render();
        }

        return view('dashboard.pos.create', compact('fnbs','fnbCat','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataTransaction['purchase_name'] = 'Pemesanan';
        $dataTransaction['responsible'] = auth()->user()->username;
        $dataTransaction['pos_number'] = IdGenerator::generate(['table' => 'pos', 'length' => 10, 'prefix' =>'TRX-','reset_on_prefix_change' => true ,'field' => 'pos_number']);
        $dataTransaction['total'] = $request->totalHarga;
        if($request->state == 'Selesai'){
            $dataTransaction['end_date'] = now();
            $dataTransaction['end_by'] = auth()->user()->username;
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
        
        return redirect('/pos/create')->with(['success_create'=>'Data transaksi penjualan berhasil disimpan.','pos_id' => $posTransaction->pos_number]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pos $po)
    {
        return view('dashboard.pos.show',[
            'pos'=>$po,
            'title'=>"Info Transaksi Penjualan"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pos $po)
    {
        $menus = FoodNBeverages::select('name')->get();
        $categories = FoodNBeverages::select('type')->distinct()->get();

        $menuData = FoodNBeverages::pluck('name')->toArray();
        $checkMenu = False;

        foreach($po->dtl_pos as $details){
            if (in_array($details->name, $menuData)) {
                // 
            }else{
                $checkMenu = True;
            }
        }

        if ($po->state == 'Proses' && $checkMenu != True){
            return view('dashboard.pos.edit',[
                'pos'=>$po,
                'menus'=>$menus,
                'categories'=>$categories,
                'title'=>"Ubah Data Transaksi Penjualan"
            ]);
        } else {
            if ($checkMenu == True && $po->state == 'Proses'){
                return view('dashboard.pos.editlock',[
                    'pos'=>$po,
                    'check_menu'=>$checkMenu,
                    'announce' => 'Rincian penjualan tidak dapat diubah karena terdapat menu yang berubah atau terhapus',
                    'title'=>"Ubah Data Transaksi Penjualan"
                ]);
            } else{
                return view('dashboard.pos.editlock',[
                    'pos'=>$po,
                    'check_menu'=>$checkMenu,
                    'announce' => 'Rincian penjualan tidak dapat diubah karena status transaksi telah '.$po->state.'',
                    'title'=>"Ubah Data Transaksi Penjualan"
                ]);
            }
        }

        
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
    public function destroy(Pos $po)
    {
        Pos::destroy($po->id);

        return redirect('/transactions')->with('success','Catatan Transaksi Berhasil Dihapus ');
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
                "description" => $menuData->description,
                "price" => $menuData->price,
                "image" => $menuData->image
            ];
        }
          
        session()->put('cart', $cart);
        return response()->json([
            'cart_view' => view('dashboard.pos.cart')->render(),
            'modal_view' => view('dashboard.pos.modal')->render(),
        ]);
        // return view('dashboard.pos.cart')->render();
        // return redirect()->back()->with('success', 'Berhasil menambahkan menu ke keranjang');
    }

    public function updateQty(Request $request)
    {
        // dd($request);
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            // session()->flash('success', 'Berhasil merubah jumlah');
            return response()->json([
                'cart_view' => view('dashboard.pos.cart')->render(),
                'modal_view' => view('dashboard.pos.modal')->render(),
            ]);
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
            // session()->flash('success', 'Berhasil menghapus keranjang menu');
            return response()->json([
                'cart_view' => view('dashboard.pos.cart')->render(),
                'modal_view' => view('dashboard.pos.modal')->render(),
            ]);
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
        return response()->json([
            'cart_view' => view('dashboard.pos.cart')->render(),
            'modal_view' => view('dashboard.pos.modal')->render(),
        ]);
    }

    public function updateStatus(Request $request)
    {
        $endDate = now();
        $endBy = auth()->user()->username;
        $newStatus = $request->state;
        Pos::where('id', $request->pos_id)
            ->update(['state'=>$newStatus, 'end_date'=>$endDate,'end_by'=>$endBy]);  
        
        session()->flash('success', 'Berhasil Merubah Status Penjualan');   
    }

    public function printStruk(Pos $pos)
    {
        return view('dashboard.pos.struk', compact('pos'));
    }
}
