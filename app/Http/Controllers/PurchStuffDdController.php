<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchStuffDdController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $stuffs = Stuff::where('stuff_name',$request->stuff_name)->select('description', 'price')->first();
        if($stuffs !== null) {
            return response()->json([
                'description' => $stuffs->description,
                'price' => $stuffs->price                
            ]);
        } else {
            return response()->json([
                'description' => '',
                'price' => 0                
            ]);
        }
    }
}
