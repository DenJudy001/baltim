<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FoodNBeverages;
use Illuminate\Http\Request;

class PosMenuDetailsDdController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $menu = FoodNBeverages::where('name',$request->name)->select('description', 'price')->first();
        if($menu !== null) {
            return response()->json([
                'description' => $menu->description,
                'price' => $menu->price                
            ]);
        } else {
            return response()->json([
                'description' => '',
                'price' => 0                
            ]);
        }
    }
}
