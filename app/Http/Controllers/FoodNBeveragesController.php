<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodNBeverages;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class FoodNBeveragesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.fnb.index',[
            'fnbs'=>FoodNBeverages::all('id','code','name','type','price'),
            'title'=>"Daftar Menu"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.fnb.create',[
            'categs'=>FoodNBeverages::select('type')->distinct()->get(),
            'title'=>"Buat Menu"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|min:3|max:5|unique:food_n_beverages',
            'name' => 'required|max:255|unique:food_n_beverages',
            'type' => 'required',
            'price' => 'required|integer|min:1',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validatedData['description'] = $request->description;
        $validatedData['name'] = ucwords($request->name);
        $validatedData['type'] = ucwords($request->type);
        $validatedData['code'] = strtoupper($request->code);

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $validatedData['image'] = $image_name;
        } else{
            $validatedData['image'] = 'food_3.jpg';
        }
        
        FoodNBeverages::create($validatedData);

        return redirect('/fnb')->with('success','Berhasil Menambah Menu Baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(FoodNBeverages $foodNBeverages)
    {
        return view('dashboard.fnb.show',[
            'menu'=>$foodNBeverages,
            'title'=>"Info Menu"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodNBeverages $foodNBeverages)
    {
        return view('dashboard.fnb.edit',[
            'fnb'=>$foodNBeverages,
            'categs'=>FoodNBeverages::select('type')->distinct()->get(),
            'title'=>"Ubah Menu"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FoodNBeverages $foodNBeverages)
    {
        $rules =[
            'type' => 'required',
            'price' => 'required|integer|min:1',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        
        if($request->name != $foodNBeverages->name) {
            $rules['name'] = 'required|max:255|unique:food_n_beverages';
        }
        if($request->code != $foodNBeverages->code) {
            $rules['code'] = 'required|min:3|max:5|unique:food_n_beverages';
        }
        
        $validatedData = $request -> validate($rules);
        
        if($request->hasFile('image')) {
            if($request->oldImage){
                if($request->oldImage != 'food_3.jpg'){
                    $imagePath = public_path('images/' . $request->oldImage);
    
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }   
                }
            }
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $validatedData['image'] = $image_name;
        }else{
            $validatedData['image'] = 'food_3.jpg';
        }
        $validatedData['description'] = $request->description;
        $validatedData['name'] = ucwords($request->name);
        $validatedData['type'] = ucwords($request->type);
        $validatedData['code'] = strtoupper($request->code);
        FoodNBeverages::where('id', $foodNBeverages->id)
            ->update($validatedData);

        return redirect('/fnb')->with('success','Berhasil Ubah Menu');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoodNBeverages $foodNBeverages)
    {  
        if($foodNBeverages->image != 'food_3.jpg'){
            $imagePath = public_path('images/' . $foodNBeverages->image);
    
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }       
        }

        FoodNBeverages::destroy($foodNBeverages->id);

        return redirect('/fnb')->with('success','Berhasil Hapus Menu ');
    }
}
