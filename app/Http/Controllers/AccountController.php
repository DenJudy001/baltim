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
        ->select('purchase_number', 'total', 'state', 'updated_at');

        $salary = DB::table('employee_salaries')
        ->select('salary_number', 'salary', 'state', 'updated_at');

        $pos = DB::table('pos')->select('pos_number', 'total', 'state', 'updated_at');

        $transactions = $purchase->union($salary)->union($pos)->orderBy('updated_at', 'desc')->get();
        $title = "Catatan Keuangan";

        return view('dashboard.account.index', compact('transactions','title'));
    }


}
