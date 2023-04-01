<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index(){

        $transactions = DB::table('purchases')
        ->select('purchase_number', 'total', 'state')
        ->union(DB::table('employee_salaries')
                ->select('salary_number', 'salary', 'state'))
        ->get();

        return view('dashboard.account.index',[
            'transactions'=>$transactions
        ]);
    }


}
