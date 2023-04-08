<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FoodNBeverages;
use Illuminate\Http\Request;

class PosMenuDdController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $menu = FoodNBeverages::all();
        $PosFiltered = $menu->pluck('name');
        $categories = FoodNBeverages::distinct()->pluck('type');
        return response()->json(['menu'=>$PosFiltered,'categ'=>$categories]);
    }
}
