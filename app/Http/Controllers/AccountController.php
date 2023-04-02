<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index(){

        $purchase = DB::table('purchases')
        ->select('purchase_number', 'total', 'state');

        $salary = DB::table('employee_salaries')
        ->select('salary_number', 'salary', 'state');

        $pos = DB::table('pos')->select('pos_number', 'total', 'state');

        $transactions = $purchase->union($salary)->union($pos)->get();

        return view('dashboard.account.index',[
            'transactions'=>$transactions
        ]);
    }


}
