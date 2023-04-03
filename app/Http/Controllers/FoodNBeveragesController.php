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
            'fnbs'=>FoodNBeverages::all('id','name','type','price')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.fnb.create',[
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:food_n_beverages',
            'type' => 'required',
            'price' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validatedData['description'] = $request->description;

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodNBeverages $foodNBeverages)
    {
        return view('dashboard.fnb.edit',[
            'fnb'=>$foodNBeverages
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FoodNBeverages $foodNBeverages)
    {
        $rules =[
            'type' => 'required',
            'price' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        
        if($request->name != $foodNBeverages->name) {
            $rules['name'] = 'required|max:255|unique:food_n_beverages';
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
