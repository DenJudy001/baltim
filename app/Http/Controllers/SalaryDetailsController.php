<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SalaryDetailsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $value = User::where('id',$request->id)->select('salary')->first();
        if($value !== null) {
            return response()->json([
                'salary' => $value->salary            
            ]);
        } else {
            return response()->json([
                'salary' => 0              
            ]);
        }
    }
}
