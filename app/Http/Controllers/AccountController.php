<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index(){
        return view('dashboard.account.index',[
            'purchase'=>Purchase::all('purchase_number','total','state')
        ]);
    }


}
